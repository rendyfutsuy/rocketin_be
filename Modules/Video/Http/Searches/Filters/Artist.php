<?php

namespace Modules\Video\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Artist
{
    /** @var int|string|null */
    protected $artist;

    /**
     * @param  int|string|null $artist
     * @return void
     */
    public function __construct($artist = null)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $scripture, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($scripture);
        }

        $scripture->whereHas('artists', function ($artist) {
            $artist->where('name', 'like', '%'. $this->keyword() .'%');
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
        if ($this->artist) {
            return $this->artist;
        }

        return request('artist') ?? request('artist');
    }
}
