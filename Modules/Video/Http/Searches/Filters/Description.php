<?php

namespace Modules\Video\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Description
{
    /** @var int|string|null */
    protected $description;

    /**
     * @param  int|string|null $description
     * @return void
     */
    public function __construct($description = null)
    {
        $this->description = $description;
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
            $scriptures->where('description', 'like', '%'. $this->keyword() .'%');
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
        if ($this->description) {
            return $this->description;
        }

        return request('description') ?? request('desc');
    }
}
