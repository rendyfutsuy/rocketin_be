<?php

namespace Modules\Post\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Title
{
    /** @var int|string|null */
    protected $q;

    /**
     * @param  int|string|null $q
     * @return void
     */
    public function __construct($q = null)
    {
        $this->q = $q;
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
            $scriptures->where('title', 'like', '%'. $this->keyword() .'%');
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
        if ($this->q) {
            return $this->q;
        }

        return request('title') ?? request('q');
    }
}
