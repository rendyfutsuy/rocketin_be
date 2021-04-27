<?php

namespace Modules\ContributorPanel\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowActivationForm extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'e' => 'required',
        ]);

        $encodedEmail = $request->e;
        $hiddenEmail = mask_email(base64_decode($encodedEmail));

        return view('contributorPanel::auth.activation', compact('encodedEmail', 'hiddenEmail'));
    }
}