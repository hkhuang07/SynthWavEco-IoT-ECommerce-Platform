<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Imports\OrderStatusImport;
use App\Exports\OrderStatusExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderStatusController extends Controller
{
    public function getList()
    {
        $statuses = OrderStatus::all();
        return view('administrator.order_statuses.list', compact('statuses'));
    }
    
    public function getAdd()
    {
        return view('administrator.order_statuses.add');
    }
    
    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
			'name' => ['required', 'string', 'max:255', 'unique:order_statuses'],
        ]);
        
        $orm = new OrderStatus();
        $orm->name = $request->name;
        $orm->save();
        
        return redirect()->route('administrator.order_statuses')->with('success', 'Added order status successfully.');
    }
    
    public function getUpdate($id)
    {
        $status = OrderStatus::findOrFail($id);
        return view('administrator.order_statuses.edit', compact('order_statuses'));
    }
    
    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
			'name' => ['required', 'string', 'max:255', 'unique:order_statuses,name,' . $id],
		]);
		
        $orm = OrderStatus::findOrFail($id);
        $orm->name = $request->name;
        $orm->save();
            
        return redirect()->route('administrator.order_statuses')->with('success', 'Updated order status successfully.');
    }
    
    public function getDelete($id)
    {
        $orm = OrderStatus::findOrFail($id);
        
        if ($orm->orders()->count() > 0) {
            return redirect()->route('administrator.order_statuses')->with('error', 'Cannot delete: There are still orders using this status.');
        }
        
        $orm->delete();

        return redirect()->route('administrator.order_statuses')->with('success', 'Deleted order status successfully.');
    }

      public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new OrderStatusImport, $request->file('file_excel'));
            return redirect()->route('administrator.order_statuses')->with('success', 'Imported order statuses successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


    public function getExport()
    {
        return Excel::download(new OrderStatusExport, 'order-statuses-list.xlsx');
    }
}