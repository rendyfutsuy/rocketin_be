<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;

class IsSeller
{

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword() || $this->keyword() == 'false' ) {
            return $next($user);
        }
        
        $user->where('level', User::REGISTERED);

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        return request('seller');
    }
}
