<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified'); // Ensure user is verified
    }

    public function show()
    {
        // Users can only view their own profile
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        // Users can only edit their own profile
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->user_id.',user_id',
            'user_mobile_no' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => ['nullable', 'min:8', 'confirmed', Password::defaults()],
        ]);

        // Update basic info
        $user->update([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'user_mobile_no' => $request->user_mobile_no,
        ]);

        // Update password if provided
        if ($request->new_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect']);
            }

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}