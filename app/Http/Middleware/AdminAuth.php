<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminId = $request->session()->get('admin_user_id');
        $admin = $adminId ? User::whereKey($adminId)->where('is_admin', true)->first() : null;

        if (!$admin) {
            $request->session()->forget('admin_user_id');

            return redirect()->route('admin.login');
        }

        view()->share('adminUser', $admin);

        return $next($request);
    }
}
