<?php

namespace Modules\Auth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showForm(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $encodedEmail = $request->email;
        $lang = $request->lang;
        
        return view('auth::reset_password.form', compact('encodedEmail', 'lang'));
    }

    public function showSuccess(Request $request)
    {
        $lang = $request->lang;
        return view('auth::reset_password.success', compact('lang'));
    }
}
