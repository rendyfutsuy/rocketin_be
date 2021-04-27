<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class UserName
{
    /** @var int|string|null */
    protected $userName;

    /**
     * @param  int|string|null $userName
     * @return void
     */
    public function __construct($userName = null)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($user);
        }

        $user->where('username', 'like', $this->keyword() .'%');

        return $next($user);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->userName) {
            return $this->userName;
        }

        return request('username') ?? request('q');
    }
}
