<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use App\Http\Controllers\Controller;
use Modules\Post\Http\Searches\EditorPostSearch;
use Modules\Post\Http\Resources\PostResourceCollection;

class ShowAllWaitPost extends Controller
{
    /** @var EditorPostsSearch */
    protected $search;

    public function __construct(EditorPostSearch $search)
    {
        $this->search= $search;
    }

    public function __invoke(Request $request)
    {
        $posts = $this->search->apply()
            ->where('status', Post::WAITED)
            ->orderBy('id', $request->get('order_by', 'DESC'))
            ->paginate($request->per_page ?? 5);

        return new PostResourceCollection($posts);
    }
}