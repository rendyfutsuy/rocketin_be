<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Post\Http\Searches\EditorPostSearch;
use Modules\Post\Http\Resources\PostResourceCollection;

class ShowAllPost extends Controller
{
    /** @var EditorPostsSearch */
    protected $search;

    public function __construct(EditorPostSearch $search)
    {
        $this->search= $search;
    }

    public function __invoke(Request $request)
    {
        $posts = $this->search->apply()->orderBy('id', $request->get('order_by', 'DESC'))->paginate($request->per_page ?? 5);

        return new PostResourceCollection($posts);
    }
}