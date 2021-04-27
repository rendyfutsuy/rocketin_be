<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Media\Http\Searches\EditorMediaSearch;
use Modules\Media\Http\Resources\MediaResourceCollection;

class ShowAllMedia extends Controller
{
    /** @var EditorMediasSearch */
    protected $search;

    public function __construct(EditorMediaSearch $search)
    {
        $this->search= $search;
    }

    public function __invoke(Request $request)
    {
        $posts = $this->search->apply()->paginate($request->per_page ?? 5);

        return new MediaResourceCollection($posts);
    }
}