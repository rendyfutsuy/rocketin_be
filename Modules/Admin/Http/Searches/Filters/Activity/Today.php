<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Today
{
    /** @var string|null */
    protected $day;

    /**
     * @param  string|null $day
     * @return void
     */
    public function __construct($day = null)
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $log, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($log);
        }

        $log->whereBetween('created_at', [
            Carbon::parse($this->keyword())->format('Y-m-d 00:00:00'),
            Carbon::parse($this->keyword())->format('Y-m-d 23:59:59'),
        ]);

        return $next($log);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if (! request()->has('today')) {
            return null;
        }

        if (! $this->day) {
            return null;
        }

        return $this->day;
    }
}
