<?php

namespace Modules\Video\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Duration
{
    /** @var int|string|null */
    protected $duration;

    /**
     * @param  int|string|null $duration
     * @return void
     */
    public function __construct($duration = null)
    {
        $this->duration = $duration;
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
            $scriptures->where('duration', '>='. $this->keyword());
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
        if ($this->duration) {
            return $this->duration;
        }

        return request('duration') ?? request('duration');
    }
}
