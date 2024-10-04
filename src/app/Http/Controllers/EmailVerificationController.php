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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
    }

    /**
     * Verify the user's email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // メールアドレスがすでに確認済みであるかチェック
        if (! hash_equals((string) $hash, (string) sha1($user->email))) {
            return response()->json(['message' => 'Invalid hash'], 403);
        }

        // メールを確認
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 409);
        }

        // メールアドレスを確認する
        $user->markEmailAsVerified();

        // Email verified eventを発火
        event(new Verified($user));

        // 追加の処理（リダイレクトなど）
        return redirect()->route('mypage')->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = Auth::user();

        // メールアドレスがすでに確認済みであるかチェック
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 409);
        }

        // メールを再送信
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent.']);
    }
}
