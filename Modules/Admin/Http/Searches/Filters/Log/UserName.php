<?php

namespace Modules\Admin\Http\Searches\Filters\Log;

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
    public function handle(Builder $logs, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($logs);
        }

        $logs->whereHas('user', function ($user) {
            $user->where('username', 'like', $this->keyword() .'%');
        });

        return $next($logs);
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
