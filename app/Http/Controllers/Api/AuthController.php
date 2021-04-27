<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Logout;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Localizations\RequestLocalization;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\AuthResponses;

class AuthController extends Controller
{
    use AuthResponses, RequestLocalization;

    const FAIL = 100;
    const SUCCESS = 200;

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkToken(Request $request)
    {
        $authorization = $request->header('authorization');
        
        if (empty($authorization)) {
            return response()->json([
                'message' => $this->translate('auth::auth.no-auth', $this->getLocale($request)),
            ], 403);
        }
        
        try {
            JWTAuth::parseToken()->authenticate();
            return response()->json([
                'message' => $this->translate('auth::auth.token-valid', $this->getLocale($request)),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $this->translate('auth::auth.need-refresh-token', $this->getLocale($request)),
            ], 401);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $userId = auth()->user()->id;

        event(new Logout('api', auth('api')->user()));

        auth('api')->logout();

        return response()->json([
            'message' => $this->translate('auth::logout.success', $this->getLocale($request)),
        ]);
    }

     /**
     * Get the token array structure.
     *
     * @param  boolean $token
     * @param  integer $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $status = 200)
    {
        return response()->json([
            'user_id' => auth('api')->id() ?? null,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ], $status);
    }
}
