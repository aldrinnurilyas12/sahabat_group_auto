<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $nik    = $request->input('nik');
        $email = $request->input('email');

        $nikUser = DB::table('v_users')->where('nik', $nik)->exists();
        $emailUser = DB::table('v_users')
            ->select('email')
            ->where('email', $email)
            ->where('nik', $nik)->exists();


        if (!$emailUser && !$nikUser) {
            RateLimiter::hit('password-reset-email:' . $email . $nik);

            throw ValidationException::withMessages([
                'email' => 'Email tidak ditemukan',
                'nik'   =>  'Nik tidak ditemukan'
            ]);
        } elseif (!$nikUser) {
            RateLimiter::hit('password-reset-email:' . $nik);

            throw ValidationException::withMessages([
                'nik' => 'Nik tidak sesuai'
            ]);
        } elseif (!$emailUser) {
            RateLimiter::hit('password-reset-email:' . $email);

            throw ValidationException::withMessages([
                'email' => 'Email tidak tersedia.'
            ]);
        }


        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
