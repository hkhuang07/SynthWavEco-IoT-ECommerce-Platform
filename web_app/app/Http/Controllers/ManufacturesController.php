<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Imports\ManufacturersImport;
use App\Exports\ManufacturesExport;
use Maatwebsite\Excel\Facades\Excel;


class ManufacturesController extends Controller
{
    public function getList()
    {
        //$manufacturers = Manufacturer::withCount('products')->get();
        $manufacturers = Manufacturer::all();
        return view('administrator.manufacturers.list', compact('manufacturers'));
    }

    public function getAdd()
    {
        return view('administrator.manufacturers.add');
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            //'name' => 'required|unique:manufacturers,name,'.$id,
            'name' => ['required', 'string', 'max:255', 'unique:manufacturers'],
            'contact_email' => ['nullable', 'email'],
            'contact_phones' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('manufacturers', $request->file('logo'), $filename);
        }

        $orm = new Manufacturer();
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name);
        $orm->address = $request->address;
        $orm->description = $request->description;
        $orm->contact_phone = $request->contact_phone;
        $orm->contact_email = $request->contact_email;
        $orm->logo = $path ?? null;
        $orm->save();

        /*Manufacturer::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'description' => $request->description,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
        ]);*/

        return redirect()->route('administrator.manufacturers')->with('success', 'Added manufacturer successfully.');
    }

    public function getUpdate($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        return view('administrator.manufacturers.edit', compact('manufacturer'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
            //'name' => 'required|unique:manufacturers,name,'.$id,
            'name' => ['required', 'string', 'max:255', 'unique:manufacturers,name,' . $id],
            'contact_email' => ['nullable', 'email'],
            'contact_phone' => ['string', 'max:20', 'nullable'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            // Xóa file cũ
            $orm = Manufacturer::find($id);
            if (!empty($orm->logo)) Storage::delete($orm->logo);
            // Upload file mới
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('manufacturers', $request->file('logo'), $filename);
        }

        $orm = Manufacturer::findOrFail($id);
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name);
        $orm->address = $request->address;
        $orm->description = $request->description;
        $orm->contact_phone = $request->contact_phone;
        $orm->contact_email = $request->contact_email;
        $orm->logo = $path ?? $orm->logo;
        $orm->save();

        /*$manufacturer->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'address' => $request->address,
            'description' => $request->description,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
        ]);*/

        return redirect()->route('administrator.manufacturers')->with('success', 'Updated manufacturer successfully.');
    }

    public function getDelete($id)
    {
        //Manufacturer::findOrFail($id)->delete();
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->delete();

        if (!empty($manufacturer->logo)) Storage::delete($manufacturer->logo);

        return redirect()->route('administrator.manufacturers')->with('success', 'Deleted manufacturer successfully.');
    }

    public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new ManufacturersImport, $request->file('file_excel'));
            return redirect()->route('administrator.manufacturers')->with('success', 'Imported manufacturers successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function getExport()
    {
        return Excel::download(new ManufacturesExport, 'manufacturers-list.xlsx');
    }
}
