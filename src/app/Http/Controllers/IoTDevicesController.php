<?php

namespace App\Http\Controllers;

use App\Models\IoTDevice;
use App\Models\DeviceMetric;
use App\Models\AlertThreshold;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class IoTDevicesController extends Controller
{
    public function getList()
    {
        $devices = IoTDevice::with(['product', 'metrics', 'thresholds'])
            ->withCount('metrics')
            ->orderBy('created_at', 'desc')
            ->get();
        $products = Product::all();
        return view('administrator.iot_devices.list', compact('devices', 'products'));
    }

    public function getAdd()
    {
        $products = Product::all();
        return view('administrator.iot_devices.add', compact('products'));
    }

    public function postAdd(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'device_id' => ['required', 'unique:iot_devices,device_id', 'max:50'],
            'location' => ['nullable', 'max:100'],
            'metrics' => ['nullable', 'array'],
            'metrics.*.metric_key' => ['required_with:metrics', 'max:20'],
            'metrics.*.description' => ['required_with:metrics', 'max:100'],
            'metrics.*.unit' => ['required_with:metrics', 'max:20'],
            'thresholds' => ['nullable', 'array'],
            'thresholds.*.metric_key' => ['required_with:thresholds', 'max:20'],
            'thresholds.*.min_value' => ['nullable', 'numeric'],
            'thresholds.*.max_value' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();
        try {
            $device = IoTDevice::create([
                'product_id' => $request->product_id,
                'device_id' => $request->device_id,
                'location' => $request->location,
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Create metrics
            if ($request->has('metrics') && is_array($request->metrics)) {
                foreach ($request->metrics as $metric) {
                    if (!empty($metric['metric_key'])) {
                        DeviceMetric::create([
                            'iot_device_id' => $device->id,
                            'metric_key' => $metric['metric_key'],
                            'description' => $metric['description'],
                            'unit' => $metric['unit'],
                        ]);
                    }
                }
            }

            // Create thresholds
            if ($request->has('thresholds') && is_array($request->thresholds)) {
                foreach ($request->thresholds as $threshold) {
                    if (!empty($threshold['metric_key'])) {
                        AlertThreshold::create([
                            'iot_device_id' => $device->id,
                            'metric_key' => $threshold['metric_key'],
                            'min_value' => $threshold['min_value'] ?? null,
                            'max_value' => $threshold['max_value'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('administrator.iot_devices')->with('success', 'IoT Device created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create device: ' . $e->getMessage())->withInput();
        }
    }

    public function getUpdate($id)
    {
        $device = IoTDevice::with(['product', 'metrics', 'thresholds'])->findOrFail($id);
        $products = Product::all();
        return view('administrator.iot_devices.update', compact('device', 'products'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'device_id' => ['required', 'max:50', Rule::unique('iot_devices')->ignore($id)],
            'location' => ['nullable', 'max:100'],
            'metrics' => ['nullable', 'array'],
            'metrics.*.metric_key' => ['required_with:metrics', 'max:10'],
            'metrics.*.description' => ['required_with:metrics', 'max:100'],
            'metrics.*.unit' => ['required_with:metrics', 'max:20'],
            'thresholds' => ['nullable', 'array'],
            'thresholds.*.metric_key' => ['required_with:thresholds', 'max:20'],
            'thresholds.*.min_value' => ['nullable', 'numeric'],
            'thresholds.*.max_value' => ['nullable', 'numeric'],
        ]);

        DB::beginTransaction();
        try {
            $device = IoTDevice::findOrFail($id);
            $device->update([
                'product_id' => $request->product_id,
                'device_id' => $request->device_id,
                'location' => $request->location,
                'is_active' => $request->boolean('is_active', $device->is_active),
            ]);

            // Delete old metrics and create new ones
            DeviceMetric::where('iot_device_id', $id)->delete();
            if ($request->has('metrics') && is_array($request->metrics)) {
                foreach ($request->metrics as $metric) {
                    if (!empty($metric['metric_key'])) {
                        DeviceMetric::create([
                            'iot_device_id' => $device->id,
                            'metric_key' => $metric['metric_key'],
                            'description' => $metric['description'],
                            'unit' => $metric['unit'],
                        ]);
                    }
                }
            }

            // Delete old thresholds and create new ones
            AlertThreshold::where('iot_device_id', $id)->delete();
            if ($request->has('thresholds') && is_array($request->thresholds)) {
                foreach ($request->thresholds as $threshold) {
                    if (!empty($threshold['metric_key'])) {
                        AlertThreshold::create([
                            'iot_device_id' => $device->id,
                            'metric_key' => $threshold['metric_key'],
                            'min_value' => $threshold['min_value'] ?? null,
                            'max_value' => $threshold['max_value'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('administrator.iot_devices')->with('success', 'IoT Device updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update device: ' . $e->getMessage())->withInput();
        }
    }

    public function getDelete($id)
    {
        DB::beginTransaction();
        try {
            // Metrics and thresholds will be deleted via cascade
            $device = IoTDevice::findOrFail($id);
            $device->delete();

            DB::commit();
            return redirect()->route('administrator.iot_devices')->with('success', 'IoT Device deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('administrator.iot_devices')->with('error', 'Failed to delete device: ' . $e->getMessage());
        }
    }
}
