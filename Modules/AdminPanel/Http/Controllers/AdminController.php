<?php

namespace Modules\AdminPanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('adminPanel::home');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userList()
    {
        return view('adminPanel::list.user');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tagList()
    {
        return view('adminPanel::list.tag');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mediaList()
    {
        return view('adminPanel::list.media');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryList()
    {
        return view('adminPanel::list.category');
    }
    
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function activityList()
    {
        return view('adminPanel::list.activity');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postList()
    {
        return view('adminPanel::list.post');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postCreate()
    {
        return view('adminPanel::post-creation');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postEdit(Post $post)
    {
        return view('adminPanel::post-edit', compact('post'));
    }


    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postWaitList()
    {
        return view('adminPanel::list.wait-post');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postRejectedList()
    {
        return view('adminPanel::list.rejected-post');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postDetail($post)
    {
        $postId = $post;

        return view('adminPanel::details.post', compact('postId'));
    }
}
