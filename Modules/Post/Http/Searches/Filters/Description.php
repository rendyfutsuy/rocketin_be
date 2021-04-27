<?php

namespace Modules\Post\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Description
{
    /** @var int|string|null */
    protected $desc;

    /**
     * @param  int|string|null $desc
     * @return void
     */
    public function __construct($desc = null)
    {
        $this->desc = $desc;
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
            $scriptures->where('content', 'like', '%'. $this->keyword() .'%')
                ->orWhere('raw_content', 'like', '%'. $this->keyword() .'%');
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
        if ($this->desc) {
            return $this->desc;
        }

        return request('content') ?? request('desc');
    }
}
