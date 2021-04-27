<?php

namespace Modules\Admin\Http\Searches\Filters\User;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class JoinDate
{
    /** @var string|null */
    protected $joinAtStart;

    /** @var string|null */
    protected $joinAtEnd;

    /**
     * @param  string|null $joinAtStart
     * @return void
     */
    public function __construct($joinAtStart = null, $joinAtEnd = null)
    {
        $this->joinAtStart = $joinAtStart;
        $this->joinAtEnd = $joinAtEnd;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $user, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($user);
        }

        $user->when($this->joinAtStart && $this->joinAtEnd, function ($user) {
            $user->whereBetween('created_at', [
                $this->joinAtStart,
                $this->joinAtEnd
            ]);
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
        if ($this->joinAtStart) {
            return $this->joinAtStart;
        }

        $this->joinAtStart = request('join_at_start', null);
        $this->joinAtEnd = request('join_at_end', now());

        return request('join_at_start');
    }
}
