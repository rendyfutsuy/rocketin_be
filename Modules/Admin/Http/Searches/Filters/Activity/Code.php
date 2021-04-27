<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Code
{
    /** @var array */
    protected $codes;

    /**
     * @param  array $codes
     * @return void
     */
    public function __construct($codes = null)
    {
        $this->codes = $codes;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $log, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($log);
        }

        $log->whereIn('activity_code', $this->keyword());

        return $next($log);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if (! request()->has('codes')) {
            return null;
        }

        return request('codes');
    }
}
