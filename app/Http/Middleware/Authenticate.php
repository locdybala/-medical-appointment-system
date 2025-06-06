<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }
        // Nếu là route admin thì redirect về /admin/login
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }
        // Mặc định redirect về trang login frontend
        return route('login');
    }
}
