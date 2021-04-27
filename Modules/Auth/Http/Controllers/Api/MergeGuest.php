<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Modules\Auth\Events\AccountMerged;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\CustomLogin;

class MergeGuest extends CustomLogin
{
    /**
     * Get a JWT token via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $prevAccount = clone auth('api')->user();

            // auth('api')->logout();

            $this->validateLogin($request);

            $this->setUser($request);

            $user = $this->user;

            $credentials = $this->credentials($request);

            $token = auth('api')->attempt($credentials);

            if (! $token) {
                return $this->sendFailResponse();
            }

            event(new AccountMerged($prevAccount, $user));

            return response()->json([
                'merge_from_user_id' => $prevAccount->id,
                'merged_to_user_id' => $user->id,
                'message' => $this->translate('auth::activation.account_merged', $this->user->getLocale()),
                'token' => $token,
            ]);
        });
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
