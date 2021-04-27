<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Http\EmailLimiters\EmailLimiter;
use Modules\Auth\Emails\UserActivationEmail;
use App\Http\Localizations\RequestLocalization;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\AuthResponses;

class ActivationController extends Controller
{
    use AuthResponses, EmailLimiter, RequestLocalization;
    
    /** Response Statuses */
    const FAIL = 100;
    const SUCCESS = 200;

    /** Not Status */
    const REGISTER_EMAIL_LIMIT = 5;

    /**
     * Validate activating request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function attemptActivation(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'activation_code' => 'required',
        ]);

        $user = User::whereEmail(base64url_decode($request->email))->first();

        if (! $user) {
            return $this->responseMessage(self::FAIL, 'Unauthenticated', 401);
        }

        if ($user->isActivated()) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('auth::activation.email_has_activated', $this->getLocale($request)), 
                422
            );
        }

        if ($user->activation_code != $request->get('activation_code')) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('auth::activation.activation_code_wrong', $this->getLocale($request)),
                422
            );
        }

        $user->markEmailAsVerified();
        $user->recordLastOnline();
        $token = JWTAuth::fromUser($user);

        return $this->responseWithToken(
            self::SUCCESS,
            $this->translate('auth::activation.activation_successed', $this->getLocale($request)),
            $token,
            200
        );
    }

    /**
     * Resend activation code.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        $this->validate($request, ['email' => 'required']);
        $user = User::whereEmail(base64url_decode($request->email))->first();

        if (! $user) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('auth::activation.unauthorized', $this->getLocale($request)),
                401
            );
        }

        if ($user->isActivated()) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('auth::activation.email_has_activated', $this->getLocale($request)),
                422
            );
        }

        $this->attemptMail('register_email_counter_'. $user->email, self::REGISTER_EMAIL_LIMIT);

        Mail::to($user->email)->send(new UserActivationEmail($user));

        return $this->getResponses([
            'user_id' => $user->id,
            'status' => self::SUCCESS, 
            'message' => $this->translate('auth::activation.send_activation_code_to_email_successed', $this->getLocale($request))
        ], 200);
    }
}
