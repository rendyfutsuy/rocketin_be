<?php

namespace Modules\Profile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller; 
use Modules\Profile\Emails\NewPasswordSubmit;
use App\Http\Localizations\RequestLocalization;
use Modules\Profile\Http\Factories\ProfileFactory;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\AuthResponses;

class UpdatePassword extends Controller
{
    use AuthResponses, RequestLocalization;

    const FAIL = 'fail';
    const SUCCESS = 'success';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'confirmed|required|string|min:6',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->old_password, $user->password)) {
            return $this->responseMessage(
                self::FAIL,
                $this->translate('auth::profile.reset_password_fail', $this->getLocale($request)),
                403
            );
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        
        Mail::to($user)->send(new NewPasswordSubmit($user));

        return $this->responseMessage(
            self::SUCCESS,
            $this->translate('auth::profile.reset_password_success', $this->getLocale($request)),
            200
        );
    }
}