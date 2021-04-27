<?php

namespace Modules\Video\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Url
{
    /** @var int|string|null */
    protected $watch_url;

    /**
     * @param  int|string|null $watch_url
     * @return void
     */
    public function __construct($watch_url = null)
    {
        $this->watch_url = $watch_url;
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
            $scriptures->where('watch_url', 'like', '%'. $this->keyword() .'%');
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
        if ($this->watch_url) {
            return $this->watch_url;
        }

        return request('watch_url') ?? request('url');
    }
}
