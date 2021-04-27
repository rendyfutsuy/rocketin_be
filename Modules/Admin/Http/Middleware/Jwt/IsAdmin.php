<?php

namespace Modules\Admin\Http\Middleware\Jwt;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('authorization');
        
        if (empty($authorization)) {
            return $next($request);
        }
        
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'admin::auth.unauthenticated',
            ], 401);
        }

        if (! auth()->user()->isAdmin()) {
            return response()->json([
                'message' => 'admin::auth.fail',
            ], 403);
        }

        return $next($request);
    }
}
