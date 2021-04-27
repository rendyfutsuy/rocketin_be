<?php

namespace Modules\Notification\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class User
{
    /**
     * @return mixed
     */
    public function handle(Builder $notification, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($notification);
        }

        $notification->where('user_id', $this->keyword());

        return $next($notification);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        return auth()->id();
    }
}
