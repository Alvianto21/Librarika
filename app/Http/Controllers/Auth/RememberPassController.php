<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class RememberPassController extends Controller
{
    /**
     * Menampilkan halaman request reset password
     */
    public function sendLinkReset() {
        return view("login.forget", ['title' => 'Lupa Password']);
    }

    /**
     * Menagani permintaan link reset password
     */
    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::ResetLinkSent ?
            back()->with('status', __($status)) :
            back()->withErrors(['email' => __($status)]);
    }

    /**
     * Menampilkan halaman reset password
     */
    public function resetForm($token) {
        return view('login.reset', [
            'token' => $token,
            'title' => 'Reset Password'
        ]);
    }

    /**
     * Menagani proses reset password
     */
    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset ?
            redirect()->route('login')->with('status', __($status)) :
            back()->withErrors('email', __($status));
    }
}
