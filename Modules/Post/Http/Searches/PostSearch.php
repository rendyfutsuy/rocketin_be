<?php

namespace Modules\Post\Http\Searches;

use App\Http\Searches\HttpSearch;
use Illuminate\Support\Facades\DB;
use Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostSearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
            Filters\Owner::class,
            Filters\Status::class,
            Filters\Title::class,
            Filters\Description::class,
            Filters\Username::class,
            Filters\IsPublished::class
        ];
    }

    /**
     * @return Builder<Post>
     */
    protected function passable()
    {
        return Post::with(['user', 'medias', 'featuredImage']);
    }

    /**
     * @inheritdoc
     */
    protected function thenReturn($medias)
    {
        return $medias;
    }
}
