<?php

namespace Modules\Admin\Http\Searches\Filters\Log;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Name
{
    /** @var int|string|null */
    protected $name;

    /**
     * @param  int|string|null $name
     * @return void
     */
    public function __construct($name = null)
    {
        $this->name = $name;
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
            $user->where('name', 'like', $this->keyword() .'%');
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
        if ($this->name) {
            return $this->name;
        }

        return request('name');
    }
}
