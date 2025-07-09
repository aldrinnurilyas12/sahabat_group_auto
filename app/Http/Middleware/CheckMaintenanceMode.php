<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UnderDevelopmentSetting;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $maintenance = UnderDevelopmentSetting::first();

        // Route yang boleh diakses walau maintenance aktif
        $allowedRoutes = ['login_admin_sahabat_group'];

        // Always allow whitelisted routes
        if (in_array($request->route()->getName(), $allowedRoutes)) {
            return $next($request);
        }

        if ($maintenance && $maintenance->under_development === 'Ya') {
            $user = Auth::user();

            if ($user) {
                $allowedPositions = [
                    'Senior IT Application Developer',
                    'IT Application Developer Staff',
                    'IT Staff',
                ];

                if (in_array($user->position_name, $allowedPositions)) {
                    // Akses penuh termasuk ke route admin pengaturan maintenance
                    return $next($request);
                }

                // Tidak termasuk posisi yang diizinkan
                return $next($request);
            }

            // Belum login dan bukan di route yang diizinkan
            return response()->view('layouts.admin_views.under_dev_page');
        }

        // Maintenance nonaktif → izinkan semua akses
        return $next($request);
    }
}
