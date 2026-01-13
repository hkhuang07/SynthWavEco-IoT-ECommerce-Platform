<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDetailsController extends Controller
{
    public function getList()
    {
        return redirect()->route('administrator.products.list')->with('info', 'Product details are managed within the product section.');
    }
    
    public function getAdd($productId)
    {
        $product = Product::findOrFail($productId);
        $details = $product->details;
        
        return view('administrator.product_details.edit', compact('product', 'details'));
    }
    
    public function postAdd(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $request->validate([
            'memory' => 'nullable|string|max:50',
            'cpu' => 'nullable|string|max:50',
            'graphic' => 'nullable|string|max:50',
            'power_specs' => 'nullable|string|max:100', 
        ]);
 
        $details = ProductDetail::updateOrCreate(
            ['product_id' => $productId],
            [
                'memory' => $request->memory,
                'cpu' => $request->cpu,
                'graphic' => $request->graphic,
                'power_specs' => $request->power_specs,
            ]
        );

        $action = $details->wasRecentlyCreated ? 'Added' : 'Updated';
        return redirect()->route('administrator.products.getUpdate', $productId)->with('success', $action . ' product details successfully.');
    }
    
    public function postUpdate(Request $request, $productId)
    {
        return $this->postAdd($request, $productId);
    }
    
    public function getUpdate($productId)
    {
        return $this->getAdd($productId);
    }
    
    public function getDelete($productId)
    {
        $details = ProductDetail::where('product_id', $productId)->first();
        
        if ($details) {
            $details->delete();
            return redirect()->route('administrator.products.getUpdate', $productId)->with('success', 'Deleted product details successfully.');
        }
        
        return redirect()->route('administrator.products.getUpdate', $productId)->with('error', 'Cannot delete: Product details not found.');
    }
}