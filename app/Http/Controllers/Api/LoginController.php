<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\CustomAuth\CustomLogin;

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
                $this->translate('auth::activation.account_has_not_been_activated', $this->getLocale($request)),
                422
            );
        }

        $credentials = $this->credentials($request);

        $token = auth('api')->attempt($credentials);

        if (! $token) {
            return $this->sendFailResponse();
        }
        
        event(new Login('api', auth('api')->user(), false));

        return response()->json([
            'user_id' => auth('api')->id(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    public function myRules(): array
    {
        return [
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }


    /**
     * Send login failed response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendFailResponse()
    {
        return response()->json([
            'message' => $this->translate('auth::login.fail', $this->getLocale(request()))
        ], 401);
    }
}
