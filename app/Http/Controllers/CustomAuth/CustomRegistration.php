<?php

namespace App\Http\Controllers\CustomAuth;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Exceptions\EmailLimitException;
use App\Http\EmailLimiters\EmailLimiter;
use Illuminate\Support\Facades\Validator;
use Modules\Message\ServiceManager\Message;
use Modules\Auth\Emails\UserActivationEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;
use App\Http\Localizations\RequestLocalization;
use App\Http\Controllers\CustomAuth\AuthResponses;

abstract class CustomRegistration extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CustomRegistration
    |--------------------------------------------------------------------------
    |
    | need Illuminate\Foundation\Auth\RegistersUsers to work properly.
    | Serves as base to execute Registration for Users.
    |
    */

    use RegistersUsers, AuthResponses, EmailLimiter, RequestLocalization;
    

    /**Response Statuses */
    const FAIL = 100;
    const SUCCESS = 200;
    const REGISTERED = 300;

    /** @var Message */
    protected $message;

    /** Not Status */
    const REGISTER_EMAIL_LIMIT = 5;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, $this->myRules(), [
            'email.unique' => $this->translate('auth::registration.already_activated', $this->getLocale(request())),
        ]);
    }

    protected function sendOtpCode(User $user): void
    {
        $this->sendActivationEmail($user);

        $this->sendActivationMessage($user);
    }

    protected function sendActivationEmail(User $user): void
    {
        if (empty($user->email)) {
            return;
        }

        $this->attemptMail('register_email_counter_'. $user->email, self::REGISTER_EMAIL_LIMIT);

        // Mail::to($user->email)->send(new UserActivationEmail($user));
    }

    protected function sendActivationMessage(User $user): void
    {
        if (empty($user->phone)) {
            return;
        }

        if (Config::get('message.need_message_otp') == false) {
            return;
        }

        $response = $this->message->provider()->send($user->phone, $user->activation_code);
    }

    protected function myRules(): array
    {
        return [
            'user_id' => ['sometimes', 'nullable'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED);
                }),
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Modules\Auth\Models\User
     */
    protected function create(array $data)
    {
        if (request()->header('authorization') || request()->has('user_id')) {
            return $this->updateExistedUser($data);
        }
        
        return User::create($this->registerApplicant($data));
    }

    protected function registerApplicant(array $data): array
    {
        return [
            'username' => $data['username'],
            'email' => Arr::get($data, 'email') ?? null,
            'phone' => Arr::get($data, 'phone') ?? null,
            'password' => Hash::make($data['password']),
            'level' => User::REGISTERED,
            'email_verified_at' => null,
        ];
    }

    protected function generateActivationCode(int $digit = 6): int
    {
        return rand((int)str_repeat('1', $digit), (int)str_repeat('9', $digit));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Modules\Auth\Models\User
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateExistedUser(array $data)
    {
        $user = null;

        $authorization = request()->header('authorization');
        
        if ($authorization) {
            JWTAuth::parseToken()->authenticate();

            $user = clone auth('api')->user();
        } else {
            $user = User::findOrFail(request()->get('user_id'));
        }
        
        if ($user->level != User::GUEST) {
            $this->sendFailedLoginResponse();
        }

        $user->update($this->registerApplicant($data));
        Auth::logout();

        return $user;
    }

    /**
     * Get the failed login response instance.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            'email' => ['failed' => $this->translate('auth::registration.fail', $this->getLocale(request()))],
        ]);
    }

    /**
     * @throws EmailLimitException
     */
    protected function exceedLimit(): void
    {
        throw new EmailLimitException($this->translate('email.exceed_limit', $this->getLocale(request())), 429);
    }

    public function haveOtpConfirmation(Request $request): bool
    {
        return $request->email || $request->phone;
    }
}
