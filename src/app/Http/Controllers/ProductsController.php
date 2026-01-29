<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;


class ProductsController extends Controller
{
    public function getList()
    {
        $products = Product::with(['category', 'manufacturer', 'details', 'images'])->orderBy('id','desc')->get();
        $categories = Category::all();
        $manufacturers = Manufacturer::all();
        return view('administrator.products.list', compact('products', 'categories', 'manufacturers'));
    }

    public function getAdd()
    {
        $categories = Category::all();
        $manufacturers = Manufacturer::all();
        return view('administrator.products.add', compact('categories', 'manufacturers'));
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'category_id' => ['required', 'exists:categories,id'],
            'manufacturer_id' => ['required', 'exists:manufacturers,id'],
            'name' => ['required', 'string', 'max:200', 'unique:products'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            // Product Details
            'memory' => ['nullable', 'string', 'max:50'],
            'cpu' => ['nullable', 'string', 'max:50'],
            'graphic' => ['nullable', 'string', 'max:50'],
            'power_specs' => ['nullable', 'string', 'max:100'],
            // Product Images
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {

            // Create Product
            $product = Product::create([
                'category_id' => $request->category_id,
                'manufacturer_id' => $request->manufacturer_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'description' => $request->description,
            ]);

            // Create Product Details
            ProductDetail::create([
                'product_id' => $product->id,
                'memory' => $request->memory,
                'cpu' => $request->cpu,
                'graphic' => $request->graphic,
                'power_specs' => $request->power_specs,
            ]);

            // Thay phần tạo ProductImage:
            if ($request->hasFile('image')) {
                $extension = $request->file('image')->extension();
                $filename = Str::slug($request->name) . '.' . $extension;
                $path = Storage::putFileAs('products', $request->file('image'), $filename);

                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $path,
                    'is_avatar' => true,
                ]);
            }

            DB::commit();
            return redirect()->route('administrator.products')->with('success', 'Added product successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add product: ' . $e->getMessage())->withInput();
        }
    }

    public function getUpdate($id)
    {
        $product = Product::with(['details', 'images', 'category', 'manufacturer'])->findOrFail($id);
        $categories = Category::all();
        $manufacturers = Manufacturer::all();
        return view('administrator.products.edit', compact('product', 'categories', 'manufacturers'));
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
            'category_id' => ['required', 'exists:categories,id'],
            'manufacturer_id' => ['required', 'exists:manufacturers,id'],
            'name' => ['required', 'string', 'max:200', 'unique:products,name,' . $id],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            // Product Details
            'memory' => ['nullable', 'string', 'max:50'],
            'cpu' => ['nullable', 'string', 'max:50'],
            'graphic' => ['nullable', 'string', 'max:50'],
            'power_specs' => ['nullable', 'string', 'max:100'],
            // Product Images
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            // Update Product
            $product->update([
                'category_id' => $request->category_id,
                'manufacturer_id' => $request->manufacturer_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'description' => $request->description,
            ]);

            // Update or Create Product Details
            ProductDetail::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'memory' => $request->memory,
                    'cpu' => $request->cpu,
                    'graphic' => $request->graphic,
                    'power_specs' => $request->power_specs,
                ]
            );

            if ($request->hasFile('image')) {
                // Xóa file cũ
                $oldImage = $product->images()->where('is_avatar', true)->first();
                if ($oldImage && !empty($oldImage->url)) {
                    Storage::delete($oldImage->url);
                }

                // Upload file mới
                $extension = $request->file('image')->extension();
                $filename = Str::slug($request->name) . '.' . $extension;
                $path = Storage::putFileAs('products', $request->file('image'), $filename);

                if ($oldImage) {
                    $oldImage->update(['url' => $path]);
                } else {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'url' => $path,
                        'is_avatar' => true,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('administrator.products')->with('success', 'Updated product successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    public function getDelete($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            // Delete related records (cascade should handle this, but explicit is safer)
            // Xóa file ảnh trước khi xóa record
            foreach ($product->images as $image) {
                if (!empty($image->url)) Storage::delete($image->url);
            }
            $product->images()->delete();
            $product->details()->delete();
            $product->delete();

            DB::commit();
            return redirect()->route('administrator.products')->with('success', 'Deleted product successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('administrator.products')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file_excel'));
            return redirect()->route('administrator.products')->with('success', 'Imported products successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function getExport()
    {
        return Excel::download(new ProductsExport, 'products-list.xlsx');
    }
}
