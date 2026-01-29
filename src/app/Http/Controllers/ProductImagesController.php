<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class ProductImagesController extends Controller
{
    public function getList($productId)
    {
        $product = Product::findOrFail($productId);
        $images = $product->images;
        return view('administrator.product_images.list', compact('product', 'images'));
    }
    
    public function getAdd($productId)
    {
        $product = Product::findOrFail($productId);
        return view('administrator.product_images.add', compact('product'));
    }
    
    public function postAdd(Request $request, $productId)
    {
        $request->validate([
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'is_avatar' => 'nullable|boolean',
        ]);

        $product = Product::findOrFail($productId);
        
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products/' . $productId, 'public'); 

            ProductImage::create([
                'product_id' => $productId,
                'url' => Storage::url($path),
                'is_avatar' => $request->boolean('is_avatar', false),
            ]);
        }
        
        return redirect()->route('administrator.products.getUpdate', $productId)->with('success', 'Added product image successfully.');
    }
    
    public function postUpdate(Request $request, $id)
    {
        $image = ProductImage::findOrFail($id);
        
        $request->validate(['is_avatar' => 'required|boolean']);
        
        $image->update([
            'is_avatar' => $request->boolean('is_avatar'),
        ]);
        
        return redirect()->route('administrator.products.getUpdate', $image->product_id)->with('success', 'Update product image successfully.');
    }
    
    public function getUpdate($id)
    {
        $image = ProductImage::findOrFail($id);
        return view('administrator.product_images.edit', compact('image'));
    }

    public function getDelete($id)
    {
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;
        
        Storage::disk('public')->delete(str_replace('/storage', '', $image->url));
        
        $image->delete();
        
        return redirect()->route('administrator.products.getUpdate', $productId)->with('success', 'Deleted product image successfully.');
    }
}