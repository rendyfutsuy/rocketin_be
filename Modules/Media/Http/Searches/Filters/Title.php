<?php

namespace Modules\Media\Http\Searches\Filters;

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
    public function handle(Builder $media, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($media);
        }

        $media->where(function ($medias) {
            $medias->where('title', 'like', '%'. $this->keyword() .'%');
        });

        return $next($media);
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
