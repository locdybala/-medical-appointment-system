<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!Auth::check()) {
                Log::warning('Unauthorized access attempt to patient route', [
                    'ip' => $request->ip(),
                    'url' => $request->url()
                ]);
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            if (Auth::user()->role !== 'patient') {
                Log::warning('Invalid role access attempt to patient route', [
                    'user_id' => Auth::id(),
                    'role' => Auth::user()->role,
                    'url' => $request->url()
                ]);
                return response()->json(['message' => 'Forbidden'], 403);
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Error in PatientMiddleware', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
