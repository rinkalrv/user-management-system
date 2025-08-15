<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-users');
    }

    public function index()
    {
        // Get all users except the current logged in user
        $subUsers = User::where('user_id', '!=', auth()->id())->get();
        return view('sub-users.index', compact('subUsers'));
    }

    public function create()
    {
        return view('sub-users.create');
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
            'password' => Hash::make($request->password),
            'user_status' => 'active',
        ]);

        return redirect()->route('sub-users.index')->with('success', 'Sub User created successfully.');
    }

    public function show(User $subUser)
    {
        return view('sub-users.show', compact('subUser'));
    }

    public function edit(User $subUser)
    {
        return view('sub-users.edit', compact('subUser'));
    }

    public function update(Request $request, User $subUser)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $subUser->user_id . ',user_id',
            'user_mobile_no' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,user,employee',
            'user_status' => 'required|in:active,inactive',
        ]);

        $subUser->update($request->only([
            'user_name', 'email', 'user_mobile_no', 'user_type', 'user_status'
        ]));

        return redirect()->route('sub-users.index')->with('success', 'Sub User updated successfully.');
    }

    public function destroy(User $subUser)
    {
        $subUser->delete();
        return redirect()->route('sub-users.index')->with('success', 'Sub User deleted successfully.');
    }
}