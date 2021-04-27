<?php

namespace Modules\ContributorPanel\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowRegisterForm extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return view('contributorPanel::auth.register');
    }
}