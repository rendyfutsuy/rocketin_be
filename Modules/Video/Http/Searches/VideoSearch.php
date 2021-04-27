<?php

namespace Modules\Video\Http\Searches;

use App\Http\Searches\HttpSearch;
use Illuminate\Support\Facades\DB;
use Modules\Video\Models\Video;
use Illuminate\Database\Eloquent\Builder;

class VideoSearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
            Filters\Title::class,
            Filters\Description::class,
            Filters\Duration::class,
            Filters\Artist::class,
            Filters\Genre::class,
            Filters\Url::class,
        ];
    }

    /**
     * @return Builder<Video>
     */
    protected function passable()
    {
        return Video::with(['genres', 'artists']);
    }

    /**
     * @inheritdoc
     */
    protected function thenReturn($medias)
    {
        return $medias;
    }
}
