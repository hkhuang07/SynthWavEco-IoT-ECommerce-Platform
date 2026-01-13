<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UsersController extends Controller
{
    public function getList()
    {
        $users = User::with('role')->orderBy('created_at', 'asc')->get();
        //$users = User::all()->orderBy('created_at', 'desc')->get();
        $roles = Role::all();
        return view('administrator.users.list', compact('users', 'roles'));
    }

    public function getAdd()
    {
        $roles = Role::all();
        return view('administrator.users.add', compact('roles'));
    }

    public function postAdd(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'username' => ['nullable', 'unique:users,username', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'exists:roles,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'id_card' => ['nullable', 'unique:users,id_card', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'jobs' => ['nullable', 'string', 'max:255'],
            'school' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);


        $pathavt = null;
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $pathavt = Storage::putFileAs('users/avatar', $request->file('avatar'), $filename);
        }

        $pathbg = null;
        if ($request->hasFile('background')) {
            $extension = $request->file('background')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $pathbg = Storage::putFileAs('users/background', $request->file('background'), $filename);
        }


        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_active' => $request->boolean('is_active', true),
            'roles' => $request->roles,
            'email' => $request->email,
            'id_card' => $request->id_card,
            'phone' => $request->phone,
            'address' => $request->address,
            'avatar' => $pathavt ?? null,
            'background' => $pathbg ?? null,
            'jobs' => $request->jobs,
            'school' => $request->school,
            'company' => $request->company,
        ]);

        return redirect()->route('administrator.users')->with('success', 'User created successfully.');
    }

    public function getUpdate($id)
    {
        $user = User::with('role')->findOrFail($id);
        $roles = Role::all();
        return view('administrator.users.update', compact('user', 'roles'));
    }

    public function postUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:128'],
            'username' => ['nullable', 'max:50', Rule::unique('users')->ignore($id)],
            'password_new' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'exists:roles,id'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'id_card' => ['nullable', 'max:20', Rule::unique('users')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'jobs' => ['nullable', 'string', 'max:255'],
            'school' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $pathavt = null;
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $pathavt = Storage::putFileAs('users/avatar', $request->file('avatar'), $filename);
        }

        $pathbg = null;
        if ($request->hasFile('background')) {
            $extension = $request->file('background')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $pathbg = Storage::putFileAs('users/background', $request->file('background'), $filename);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->is_active = $request->boolean('is_active', $user->is_active);
        $user->roles = $request->roles;
        $user->email = $request->email;
        $user->id_card = $request->id_card;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->avatar = $pathavt ?? $user->avatar;
        $user->background = $pathbg ?? $user->background;
        $user->jobs = $request->jobs;
        $user->school = $request->school;
        $user->company = $request->company;

        if ($request->filled('password_new')) {
            $user->password = Hash::make($request->password_new);
        }

        $user->save();

        return redirect()->route('administrator.users')->with('success', 'User updated successfully.');
    }

    public function getDelete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('administrator.users')->with('error', 'Cannot delete your own account.');
        }

        if ($user->orders()->count() > 0) {
            return redirect()->route('administrator.users')->with('error', 'Cannot delete user with existing orders.');
        }

        $user->delete();

        return redirect()->route('administrator.users')->with('success', 'User deleted successfully.');
    }
}
