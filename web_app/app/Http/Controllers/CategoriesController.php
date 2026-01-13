<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\CategoriesImport;
use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesController extends Controller
{
    public function getList()
    {
        $categories = Category::all();
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('administrator.categories.list', compact('categories'));
    }

    public function getAdd()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('administrator.categories.add', compact('categories'));
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('categories', $request->file('image'), $filename);
        }

        $orm = new Category();
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->description = $request->description;
        $orm->parent_id = $request->parent_id ?? null;
        $orm->image = $path ?? null;
        $orm->save();

        return redirect()->route('administrator.categories')->with('success', 'Added category successfully.');
        //return redirect()->route('administrator.categories.list');
    }

    public function getUpdate($id)
    {
        //$category = Category::find($id);
        $category = Category::findOrFail($id);
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('administrator.categories.edit', compact('category', 'parentCategories'));
    }

    public function postUpdate(Request $request, $id)
    {
        // Kiểm tra
        $request->validateWithBag('update', [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // Xóa file cũ
            $orm = Category::find($id);
            if (!empty($orm->image)) Storage::delete($orm->image);
            // Upload file mới
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('categories', $request->file('image'), $filename);
        }

        //$orm = Category::find($id);
        $orm = Category::findOrFail($id);
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->description = $request->description;
        $orm->parent_id = $request->parent_id ?? null;
        $orm->image = $path ?? $orm->image;
        $orm->save();

        return redirect()->route('administrator.categories')->with('success', 'Updated category successfully.');
        //return redirect()->route('administrator.categories.list');
    }

    public function getDelete($id)
    {
        //$orm = Category::find($id);
        $category = Category::findOrFail($id);
        $category->delete();

        if(!empty($category->image)) Storage::delete($category->image);

        return redirect()->route('administrator.categories')->with('success', 'Deleted category successfully.');
    }

    public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new CategoriesImport, $request->file('file_excel'));
            return redirect()->route('administrator.categories')->with('success', 'Imported categories successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function getExport()
    {
        return Excel::download(new CategoriesExport, 'categories-list.xlsx');
    }

}
