<?php

namespace Modules\Media\Http\Searches;

use App\Http\Searches\HttpSearch;
use Illuminate\Support\Facades\DB;
use Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Builder;

class EditorMediaSearch extends HttpSearch
{
    protected function filters(): array
    {
        return [
            Filters\Title::class,
            Filters\Username::class,
            Filters\JoinDate::class,
        ];
    }

    /**
     * @return Builder<Media>
     */
    protected function passable()
    {
        return Media::with(['user', 'posts']);
    }

    /**
     * @inheritdoc
     */
    protected function thenReturn($medias)
    {
        return $medias;
    }
}
