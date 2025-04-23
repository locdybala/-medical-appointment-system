<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Nếu đang ở trang admin và user là admin/doctor
                if (str_starts_with($request->path(), 'admin') && ($user->isAdmin() || $user->isDoctor())) {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                
                // Nếu đang ở trang frontend
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
