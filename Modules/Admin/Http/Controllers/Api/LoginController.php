<?php

namespace Modules\Admin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Admin\Models\Admin;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Config;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\CustomLogin;

class LoginController extends CustomLogin
{
    /**
     * Get a JWT token via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $this->validateLogin($request);

        $this->setUser($request);

        $user = $this->user;

        if (! $user) {
            return $this->sendFailResponse();
        }

        if (! $user->isActivated()) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('admin::activation.account_has_not_been_activated', $this->getLocale($request)),
                422
            );
        }

        $credentials = $this->credentials($request);

        $token = auth('admin')->attempt($credentials);

        if (! $token) {
            return $this->sendFailResponse();
        }

        event(new Login('admin', auth('admin')->user(), false));

        return response()->json([
            'user_id' => auth('admin')->id(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL()
        ]);
    }

    public function myRules(): array
    {
        return [
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

    protected function setUser(Request $request): void
    {
        $this->user = Admin::where(function($user) use ($request) {
            $user->where('email', $request->login)
                ->orWhere('username', $request->login);
        })->first();
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        event(new Logout('admin', auth('admin')->user()));

        auth('admin')->logout();

        return response()->json([
            'message' => $this->translate('admin::logout.success', $this->getLocale($request)),
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        return $this->respondWithToken(auth('admin')->refresh());
    }


    /**
     * Send login failed response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendFailResponse()
    {
        return response()->json([
            'message' => $this->translate('admin::login.fail', $this->getLocale(request()))
        ], 401);
    }

    /**
     * Get the token array structure.
     *
     * @param  boolean $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'user_id' => auth()->id() ?? null,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }
}
