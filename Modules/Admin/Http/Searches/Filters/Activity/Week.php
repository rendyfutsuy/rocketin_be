<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Week
{
    /** @var string|null */
    protected $start;

    /** @var string|null */
    protected $end;

    /**
     * @param  string|null $start
     * @param  string|null $end
     * 
     * @return void
     */
    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
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
            Carbon::parse($this->start)->format('Y-m-d 00:00:00'),
            Carbon::parse($this->end)->format('Y-m-d 23:59:59'),
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
        if (! request()->has('week')) {
            return null;
        }

        return request()->has('week');
    }
}
