<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Modules\Message\ServiceManager\Message;
use Modules\Wordpress\ServiceManager\Wordpress;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\CustomRegistration;

class RegisterController extends CustomRegistration
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Wordpress $wordpress, Message $message)
    {
        $this->middleware(['guest']);
        parent::__construct($wordpress, $message);
    }

    /**
     * Register new user from mobile app.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $this->validator($request->all())->validate();

            if (! $this->haveOtpConfirmation($request)) {
                return $this->responseMessage(
                    self::FAIL,
                    $this->translate('auth::registration.does_not_have_otp_mean', $this->getLocale($request)),
                    202
                );
            }
            
            if ($request->email && User::where('email', $request->email)->exists()) {
                $user = User::where('email', $request->email)->first();
                
                $this->sendActivationEmail($user);
    
                return $this->responseMessage(
                    self::REGISTERED,
                    $this->translate('auth::registration.already_registered', $this->getLocale($request)),
                    202
                );
            }

            if ($request->phone && User::where('phone', $request->phone)->exists()) {
                $user = User::where('phone', $request->phone)->first();
                
                $this->sendActivationMessage($user);

                return $this->responseMessage(
                    self::REGISTERED,
                    $this->translate('auth::registration.phone_already_registered', $this->getLocale($request)),
                    202
                );
            }
    
            $user = $this->create($request->all());
    
            event(new Registered($user));
    
            $this->registerToWordpress($user);
    
            $this->sendOtpCode($user);
    
            return $this->responseMessage(
                self::SUCCESS,
                $this->translate('auth::registration.success', $this->getLocale($request)),
                200
            ); 
        });
    }

    protected function myRules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:128',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED)
                            ->whereNull('activation_code');
                }),
            ],
            'email' => [
                'sometimes',
                 'string',
                 'nullable',
                 'email',
                 'max:255',
                 Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED)
                            ->whereNull('activation_code');
                }),
            ],
            'phone' => [
                'sometimes',
                'string',
                'max:13',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED)
                            ->whereNull('activation_code');
                }),
            ],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    protected function userRegistrationForms(User $user): array
    {
        return [
            'name' => $user->profile->full_name,
            'email' => $user->email,
            'username' => $user->profile->wp_username,
            'nickname' => $user->profile->wp_nickname,
            'password' => $user->profile->wp_password,
            'roles' => [
                'contributor',
            ],
        ];
    }
}
