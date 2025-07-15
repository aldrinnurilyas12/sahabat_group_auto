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

        $adminWebIsUnderDev = $maintenance && $maintenance->admin_web === 'Ya';
        $landingPageWebIsUnderDev = $maintenance && $maintenance->landing_page_web === 'Ya';

        $isUnderDev = $adminWebIsUnderDev && $landingPageWebIsUnderDev;

        $allowedRoutes = ['login_admin_sahabat_group', 'login_execute'];
        $allowedPositions = [
            'Senior IT Application Developer',
            'IT Developer Staff',
            'IT Staff',
        ];

        $routeName = $request->route()?->getName();
        if (in_array($routeName, $allowedRoutes)) {
            return $next($request);
        }

        $userController = app(LoginAdminController::class);
        $user = $userController->getUsers();

        if ($isUnderDev) {
            if (!$user || !in_array($user->position_name, $allowedPositions)) {
                return response()->view('layouts.admin_views.under_dev_page');
            }
        }

        return $next($request);
    }
}
