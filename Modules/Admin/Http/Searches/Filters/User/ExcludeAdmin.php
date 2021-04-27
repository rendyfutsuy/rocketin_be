<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ExcludeAdmin
{
    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        $user->where('level', '<>', User::ADMIN);
        
        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        return;
    }
}
