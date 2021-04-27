<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class User
{
    /** @var int */
    protected $userId;

    /**
     * @param  int $userId
     * @return void
     */
    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $logs, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($logs);
        }

        $logs->where('user_id', $this->keyword());

        return $next($logs);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if (! $this->userId) {
            return null;
        }

        return $this->userId ?? request('user_id');
    }
}
