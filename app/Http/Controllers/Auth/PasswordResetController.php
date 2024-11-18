<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Mengirimkan Link Reset Password
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mengirimkan permintaan untuk mendapatkan token reset password
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => __('Link reset password telah dikirim ke email Anda.')], 200);
        }

        return response()->json(['email' => __($status)], 400);
    }

    // Reset Password setelah menerima link
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['status' => __($status)], 200)
            : response()->json(['email' => __($status)], 400);
    }
}