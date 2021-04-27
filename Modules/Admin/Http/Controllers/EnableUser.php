<?php

namespace Modules\Admin\Http\Controllers;

use DB;
use Modules\Auth\Models\User;
use App\Http\Controllers\Controller;
use Modules\Admin\Events\UserUpdated;
use App\Http\Localizations\RequestLocalization;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\AuthResponses;

class EnableUser extends Controller
{
    use AuthResponses, RequestLocalization;
    
    const FAIL = 100;
    const SUCCESS = 200;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(User $user)
    {
        DB::transaction(function () use ($user) {
            request()->request->add(['is_banned' => false]);
            
            event(new UserUpdated(auth()->user(), $user, request()));
            
            $user->update([
                'banned_at' => null
            ]); 
        });

        return $this->responseMessage(
            self::SUCCESS,
            $this->translate('admin::user.enable_success', $this->getLocale(request())),
            200
        );
    }
}
