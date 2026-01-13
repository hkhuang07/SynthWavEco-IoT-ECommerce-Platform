<?php

namespace App\Http\Controllers;

use App\Models\DeviceMetric;
use App\Models\IoTDevice; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceMetricController extends Controller
{
    public function getList()
    {
        $metrics = DeviceMetric::with('device')->get();
        return view('administrator.device_metrics.list', compact('metrics'));
    }
    
    public function getAdd()
    {
        $devices = IoTDevice::all();
        return view('administrator.device_metrics.add', compact('devices'));
    }
    
    public function postAdd(Request $request)
    {
        $request->validate([
            'iot_device_id' => 'required|exists:iot_devices,id',
            'metric_key' => [ // Key trong MongoDB JSON (t, h, m, n, p, k)
                'required', 
                'max:10', 
                Rule::unique('device_metrics')->where(function ($query) use ($request) {
                    return $query->where('iot_device_id', $request->iot_device_id);
                }),
            ],
            'description' => 'required|max:100',
            'unit' => 'required|max:20',
        ]);
        
        DeviceMetric::create($request->all());
        
        return redirect()->route('administrator.device_metrics.list')->with('success', 'Added device metric successfully.');
    }
    
    public function getUpdate($id)
    {
        $metric = DeviceMetric::findOrFail($id);
        $devices = IoTDevice::all();
        return view('administrator.device_metrics.edit', compact('metric', 'devices'));
    }
    
    public function postUpdate(Request $request, $id)
    {
        $metric = DeviceMetric::findOrFail($id);
        
        $request->validate([
            'iot_device_id' => 'required|exists:iot_devices,id',
            'metric_key' => [
                'required', 
                'max:10', 
                Rule::unique('device_metrics')->where(function ($query) use ($request) {
                    return $query->where('iot_device_id', $request->iot_device_id);
                })->ignore($metric->id),
            ],
            'description' => 'required|max:100',
            'unit' => 'required|max:20',
        ]);
        
        $metric->update($request->all());
        
        return redirect()->route('administrator.device_metrics.list')->with('success', 'Updated device metric successfully.');
    }
    
    public function getDelete($id)
    {
        DeviceMetric::findOrFail($id)->delete();
        return redirect()->route('administrator.device_metrics.list')->with('success', 'Deleted device metric successfully.');
    }
}