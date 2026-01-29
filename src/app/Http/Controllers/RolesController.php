<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\RolesImport;
use App\Exports\RolesExport;
use Maatwebsite\Excel\Facades\Excel;

class RolesController extends Controller
{
    public function getList()
    {
        $roles = Role::withCount('users')->get();
        return view('administrator.roles.list', compact('roles'));
    }

    public function postAdd(Request $request)
    {
        $request->validateWithBag('add', [
            'name' => ['required', 'unique:roles,name', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);
        $orm = new Role();
        $orm->name = $request->name;
        $orm->description = $request->description;
        $orm->save();
        return redirect()->route('administrator.roles')->with('success', 'Added role successfully.');
    }

    public function postUpdate(Request $request, $id)
    {
        $request->validateWithBag('update', [
            'name' => ['required', 'unique:roles,name,' . $id, 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $orm = Role::findOrFail($id);
        $orm->name = $request->name;
        $orm->description = $request->description;
        $orm->save();
        return redirect()->route('administrator.roles')->with('success', 'Updated role successfully.');
    }

    public function getDelete($id)
    {
        $role = Role::findOrFail($id);

        // Check if any users have this role in their roles foregin key
        $usersWithRole = User::where('roles', $role->id)->count();

        if ($usersWithRole > 0) {
            return redirect()->route('administrator.roles')->with('error', 'Cannot delete: There are still users assigned to this role.');
        }

        $role->delete();

        return redirect()->route('administrator.roles')->with('success', 'Deleted role successfully.');
    }


    public function postImport(Request $request)
    {
        $request->validateWithBag('import', [
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new RolesImport, $request->file('file_excel'));
            return redirect()->route('administrator.roles')->with('success', 'Imported roless successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


    public function getExport()
    {
        return Excel::download(new RolesExport, 'roles-list.xlsx');
    }
}
