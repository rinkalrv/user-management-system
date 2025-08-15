<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


class RegisterController extends Controller
{
    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $verificationUrl = $this->verificationUrl($user);
        $request->session()->flash('verification_url', $verificationUrl);

        Auth::logout();

        return redirect()->route('login')
        ->with('verification_url', $verificationUrl)
        ->with('status', 'Registration successful! Check below for verification link.');
    }


    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return validator($data, [
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'user', // default type
            'user_status' => 'inactive', // default status
            'activation_token' => Str::random(60),
        ]);
    }

    /**
     * Generate verification URL for demo purposes
     */
    protected function verificationUrl($user)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addDays(1), // Link expires in 24 hours
            [
                'id' => $user->user_id, // Make sure this matches your route parameter
                'hash' => sha1($user->email),
            ]
        );
    }

    /**
     * The user has been registered.
     */
    protected function registered(Request $request, $user)
    {
        // Optional: You can add additional logic here
    }

    /**
     * Where to redirect users after registration.
     */
    protected function redirectPath()
    {
        return route('home');
    }
}