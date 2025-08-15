<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-users')->except(['show', 'edit', 'update']);

    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'user_mobile_no' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,user,employee',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'user_mobile_no' => $request->user_mobile_no,
            'user_type' => $request->user_type,
            'password' => bcrypt($request->password),
            'user_status' => 'active',
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Only allow users to update their own profile unless admin
        if (!auth()->user()->isAdmin() && auth()->user()->user_id !== $user->user_id) {
            return redirect()->back()->with('error', 'You can only update your own profile.');
        }

        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'user_mobile_no' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,user,employee',
            'user_status' => 'required|in:active,inactive',
        ]);

        $user->update($request->only([
            'user_name', 'email', 'user_mobile_no', 'user_type', 'user_status'
        ]));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        if (!auth()->user()->canManageUsers()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user->update([
            'user_status' => $user->user_status === 'active' ? 'inactive' : 'active'
        ]);

        $action = $user->user_status === 'active' ? 'unblocked' : 'blocked';
        return redirect()->back()->with('success', "User {$action} successfully.");
    }
}