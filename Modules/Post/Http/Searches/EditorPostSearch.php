<?php

namespace Modules\Post\Http\Searches;

use Modules\Post\Models\Post;
use App\Http\Searches\HttpSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class EditorPostSearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
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
