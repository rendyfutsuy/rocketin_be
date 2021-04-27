<?php

namespace Modules\Post\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Username
{
    /** @var int|string|null */
    protected $username;

    /**
     * @param  int|string|null $username
     * @return void
     */
    public function __construct($username = null)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($user);
        }

        $user->whereHas('user', function ($user) {
            $user->where(function ($user) {
                $user->where('name', 'like', '%'. $this->keyword() .'%')
                    ->orWhere('username', 'like', '%'. $this->keyword() .'%');
            });
        });

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->username) {
            return $this->username;
        }

        return request('username');
    }
}
