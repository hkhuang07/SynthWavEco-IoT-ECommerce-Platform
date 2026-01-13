<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function getList()
    {
        $orderItems = OrderItem::with(['order.user', 'product'])->latest()->paginate(20);
        return view('administrator.order_items.list', compact('orderItems'));
    }
    
    // ( getAdd/postAdd không được xây dựng ở backend controller vì OrderItem được tạo tự động qua Order Frontend Logic)
    
    public function postUpdate(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $item->update([
            'quantity' => $request->quantity,
        ]);
        
        return redirect()->route('administrator.order_items.list')->with('success', 'Updated order item successfully.');
    }
    
    public function getDelete($id)
    {
        $item = OrderItem::findOrFail($id);

        $item->order->update(['total_amount' => $item->order->total_amount - ($item->quantity * $item->price_at_order)]);
        
        $item->delete();
        
        return redirect()->route('administrator.order_items.list')->with('success', 'Deleted order item successfully.');
    }
    
}