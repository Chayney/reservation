<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        if (! hash_equals((string) $hash, (string) sha1($user->email))) {
            return response()->json(['message' => 'Invalid hash'], 403);
        }
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 409);
        }
        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('mypage')->with('verified', true);
    }

    public function resend(Request $request)
    {
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 409);
        }
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent.']);
    }
}
