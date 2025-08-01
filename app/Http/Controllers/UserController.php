<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User added!');
    }

    public function edit(int $id)
    {
        $users = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('users','roles'));
    }

public function update(Request $request, int $id): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id, // validate against other users, but allow current user
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|string|exists:roles,name',
        
    ]);

    // Retrieve the user to be updated
    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    $user->syncRoles([$request->role]);

    return redirect()->route('users.index')->with('success', 'User updated!');
}


    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted!');
    }
}
