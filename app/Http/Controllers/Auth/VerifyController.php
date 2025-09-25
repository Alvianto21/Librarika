<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerifyController extends Controller
{
    /**
     * Mengirim pemberitahuan verifikasi email
     */
    public function sendEmail() {
        return view("login.verify-email", ['title' => 'Verifikasi Email']);
    }

    /**
     * Menagani verifikasi email
     */
    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/')->with('VerifySuccess', 'Email anda sudah diverifikasi.');
    }

    /**
     * Mengirim ulang link verifikasi email
     */
    public function resendEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
        return back();
    }
}
