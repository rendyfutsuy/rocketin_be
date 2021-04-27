<?php

namespace Modules\Admin\Http\Searches;

use Modules\Auth\Models\User;
use App\Http\Searches\HttpSearch;
use Modules\Profile\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Searches\Filters\User\ExcludeAdmin;

class UserListSearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
            // Filters\User\ExcludeAdmin::class,
            Filters\User\Name::class,
            Filters\User\UserName::class,
            Filters\User\Email::class,
            Filters\User\JoinDate::class,
            Filters\User\IsGuest::class,
            Filters\User\IsBanned::class,
            Filters\User\IsAdmin::class,
            Filters\User\IsActivated::class,
            Filters\User\IsSeller::class,
            Filters\User\IsUnActive::class,
            Filters\User\IsEditor::class,
        ];
    }

    /**
     * @return Builder<User>
     */
    protected function passable()
    {
        return Profile::query()
            ->withTrashed()
            ->with('posts', 'activities');
    }

    /**
     * @inheritdoc
     */
    protected function thenReturn($scriptures)
    {
        return $scriptures;
    }
}
