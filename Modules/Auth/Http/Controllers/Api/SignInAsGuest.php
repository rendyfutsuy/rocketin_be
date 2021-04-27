<?php

namespace Modules\Auth\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Localizations\RequestLocalization;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\CustomLogin;

class SignInAsGuest extends CustomLogin
{
    use RequestLocalization;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * Register new user from mobile app.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {   
        $randomName = Carbon::now()->format('YmdHis');

        $user = User::create([
            'username' => $randomName,
            'email' => null,
            'password' => Hash::make($randomName),
            'level' => User::GUEST,
            'email_verified_at' => Carbon::now(),
            'activation_code' => null,
        ]);

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

        $credentials = [
            'username' => $user->username,
            'password' => $randomName,
        ];

        $token = auth('api')->attempt($credentials);

        if (! $token) {
            return $this->sendFailResponse();
        }

        event(new Login('api', auth('api')->user(), false));

        return response()->json([
            'user_id' => auth('api')->id(),
            'name' => $user->username,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
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
