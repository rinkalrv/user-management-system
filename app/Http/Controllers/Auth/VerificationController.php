<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Models\User;
use Illuminate\Http\Request;  // Add this line
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

     /*public function verify(Request $request, $id, $hash, $token)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->email))) {
            return redirect()->route('home')->with('error', 'Invalid verification link.');
        }

        if (!hash_equals((string) $token, $user->activation_token)) {
            return redirect()->route('home')->with('error', 'Invalid verification token.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('info', 'Email already verified.');
        }

        $user->markEmailAsVerified();

        return redirect()->route('home')
            ->with('success', 'Email verified successfully! Your account is now active.');
    }*/
    
    public function verify(Request $request, $id, $hash)
{
    $user = User::findOrFail($id);

    // Check if already verified
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('info', 'Email already verified.');
    }

    // Verify hash
    if (!hash_equals((string) $hash, sha1($user->email))) {
        return redirect()->route('login')->with('error', 'Invalid verification link.');
    }

    // Mark as verified
    $user->markEmailAsVerified();

    return redirect()->route('login')
        ->with('status', 'Email verified successfully! You can now login.');
}

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('info', 'Email already verified.');
        }

        $verificationUrl = route('verification.verify', [
            'id' => $request->user()->user_id,
            'hash' => sha1($request->user()->email),
            'token' => $request->user()->activation_token,
        ]);

        return redirect()->route('home')
            ->with('verification_url', $verificationUrl)
            ->with('success', 'Verification link resent! Check your email.');
    }
}
