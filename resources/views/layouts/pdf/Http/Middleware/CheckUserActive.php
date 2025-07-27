<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $employee = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->is_active; // Gunakan guard 'employee' jika kamu tidak pakai default 'web'

        if ($employee && $employee->is_active === 'N') {
            Auth::guard('employee')->logout();
            return redirect()->route('login')->withErrors(['account_inactive' => 'Akun Anda tidak aktif.']);
        }

        return $next($request);
    }
}
