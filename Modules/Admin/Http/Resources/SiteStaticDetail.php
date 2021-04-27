<?php

namespace Modules\Admin\Http\Resources;

use Modules\Auth\Models\User;
use Modules\Post\Models\Post;
use Modules\Auth\Models\UserActivity;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteStaticDetail
{
    /**
     * @return array
     */
    public static function render()
    {
        return [
            'all_users' => User::count(),
            'banner_users' => User::guest()->count(),
            'registered_users' => User::normalUser()->count(),
            'admin_users' => User::admin()->count(),

            'all_post' => Post::count(),
            'post_today' => Post::today()->count(),
            'post_week' => Post::week()->count(),
            'post_month' => Post::month()->count(),
            'post_year' => Post::year()->count(),

            'all_users_activities' => UserActivity::count(),
            'users_activities_today' => UserActivity::today()->count(),
            'users_activities_week' => UserActivity::week()->count(),
            'users_activities_month' => UserActivity::month()->count(),
            'users_activities_year' => UserActivity::year()->count(),
        ];
    }
}
