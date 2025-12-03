<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\LoginAdminController;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function authenticate(): RedirectResponse
    {
        $this->ensureIsNotRateLimited();

        $login_access = $this->only('login')['login'];
        $field_login = filter_var($login_access, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';

        $user_available = User::where($field_login, $login_access)->first();

        if (!$user_available) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login' => 'NIK atau Email anda tidak sesuai'
            ]);
        }


        if ($user_available->is_active === 'N') {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login' => ' Akun anda sudah tidak aktif'
            ]);
        }

        if ($user_available->is_active === 'X') {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login' => 'Anda Belum melakukan verifikasi email, silahkan cek email anda untuk melakukan verifikasi.'
            ]);
        }


        if (!Auth::attempt([$field_login => $login_access, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'password' => 'Password salah, coba lagi.'
            ]);
        }

        // Jika semua cek berhasil, login pengguna
        Auth::login($user_available);
        RateLimiter::clear($this->throttleKey());
        $this->session()->regenerate();
        session()->flash('message_success', 'Welcome Back!');
        return redirect()->intended('dashboard');
    }


    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}