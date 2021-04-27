<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Modules\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;

class IsActivated
{

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword() || $this->keyword() == 'false' ) {
            return $next($user);
        }
        
        $user->whereNotNull('email_verified_at');

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        return request('activated');
    }
}
