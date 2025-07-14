<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UnderDevelopmentSetting;
use App\Http\Controllers\Api\LoginAdminController;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $maintenance = UnderDevelopmentSetting::first();
        $isUnderDev = $maintenance && $maintenance->under_development == 'Ya';

        $allowedRoutes = ['login_admin_sahabat_group', 'login_execute'];

        if ($isUnderDev) {
            // Izinkan akses ke route yang diizinkan
            if (in_array($request->route()->getName(), $allowedRoutes)) {
                return $next($request);
            }

            // Ambil data user sekali saja
            $userController = app(LoginAdminController::class);
            $user = $userController->getUsers();

            // Cek posisi user
            $allowedPositions = [
                'Senior IT Appllication Developer',
                'IT Developer Staff',
                'IT Staff',
            ];

            if ($user && in_array($user->position_name, $allowedPositions)) {
                return $next($request);
            }

            // Jika bukan user yang diizinkan
            return response()->view('layouts.admin_views.under_dev_page');
        }

        // Jika tidak dalam mode pengembangan
        return $next($request);
    }
}
