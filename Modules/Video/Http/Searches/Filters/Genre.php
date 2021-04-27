<?php

namespace Modules\Video\Http\Searches\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Genre
{
    /** @var int|string|null */
    protected $genre;

    /**
     * @param  int|string|null $genre
     * @return void
     */
    public function __construct($genre = null)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $scripture, Closure $next)
    {
        if (! $this->keyword()) {
            return $next($scripture);
        }
        
        $scripture->whereHas('genres', function ($genre) {
            $genre->where('name', 'like', '%'. $this->keyword() .'%');
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
        if ($this->genre) {
            return $this->genre;
        }

        return request('genre') ?? request('genre');
    }
}
