<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Modules\Auth\Emails\UserResetPassword;
use Modules\Auth\Http\Requests\EmailIsExists;
use App\Http\Localizations\RequestLocalization;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\AuthResponses;

class ResetPasswordController extends Controller
{
    use AuthResponses, RequestLocalization;
    
    const FAIL = 100;
    const SUCCESS = 200;

    /**
     * Send reset password verification to user email.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendVerificationEmail(EmailIsExists $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user->isActivated()) {
            return $this->responseMessage(self::FAIL, $this->translate('auth::email_reset.email_has_not_been_activated', $this->getLocale($request)), 422);
        }

        $this->sendEmail($user);

        return $this->getResponses([
            'status' => self::SUCCESS,
            'message' => $this->translate('auth::email_reset.send_reset_password_verification_email_success', $this->getLocale($request)),
            'encoded_email' => base64url_encode($request->email),
        ], 200);
    }

    /**
     * Resend reset password verification to user email.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationEmail(EmailIsExists $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user->activation_code) {
            return $this->responseMessage(self::FAIL, $this->translate('auth::email_reset.activation_code_null', $this->getLocale($request)), 422);
        };

        $this->sendEmail($user);

        return $this->getResponses([
            'status' => self::SUCCESS,
            'message' => $this->translate('auth::email_reset.send_reset_password_verification_email_success', $this->getLocale($request)),
            'encoded_email' => base64url_encode($request->email),
        ], 200);
    }

    /**
     * Reset user password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'confirmed|required|string|min:6',
        ]);

        $user = User::whereEmail(base64url_decode($request->email))->first();

        if (!$user) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('auth::email_reset.unauthenticated_email', $this->getLocale($request)),
                422
            );
        }

        $user->password = Hash::make($request->password);
        $user->activation_code = null;
        $user->save();

        if (! $request->expectsJson()) {
            return redirect(route('auth.reset.password.success', [
                'lang' => $user->getLocale(),
            ]));
        }


        return $this->responseMessage(
            self::SUCCESS,
            $this->translate('auth::email_reset.reset_password_success', $this->getLocale($request)),
            200
        );
    }

    /** Send the email */
    public function sendEmail(User $user) :void
    {
        Mail::to($user)->send(new UserResetPassword($user));
    }

    protected function generateActivationCode(int $digit = 6): int
    {
        return rand((int)str_repeat('1', $digit), (int)str_repeat('9', $digit));
    }
}
