<?php

namespace Modules\Post\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Status
{
    /** @var int|string|null */
    protected $status;

    /**
     * @param  int|string|null $status
     * @return void
     */
    public function __construct($status = null)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $scripture, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($scripture);
        }

        $scripture->where(function ($scriptures) {
            $scriptures->where('status', $this->keyword());
        });

        return $next($scripture);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->status) {
            return $this->status;
        }

        return request('status');
    }
}
