<?php

namespace Modules\Admin\Http\Searches\Filters\Activity;

use Closure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Type
{
    /** @var array */
    protected $types;

    /**
     * @param  array $types
     * @return void
     */
    public function __construct($types = null)
    {
        $this->types = $types;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $log, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($log);
        }

        $log->whereIn('type', $this->keyword());

        return $next($log);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if (! request()->has('types')) {
            return null;
        }

        return request('types');
    }
}
