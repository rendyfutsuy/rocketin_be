<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class IsBanned
{

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword() || $this->keyword() == 'false' ) {
            return $next($user);
        }
        if (request('banned') == true || request('banned') == 'true' ) {
            $user->whereNotNull('banned_at');
        } else {
            $user->whereNull('banned_at');
        }


        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        return request('banned');
    }
}
