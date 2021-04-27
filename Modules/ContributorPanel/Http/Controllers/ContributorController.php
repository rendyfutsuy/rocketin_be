<?php

namespace Modules\ContributorPanel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ContributorController extends Controller
{
    public function __construct()
    {
        # code...
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('contributorPanel::home');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userList()
    {
        return view('contributorPanel::list.user');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tagList()
    {
        return view('contributorPanel::list.tag');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mediaList()
    {
        return view('contributorPanel::list.media');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryList()
    {
        return view('contributorPanel::list.category');
    }
    
    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function activityList()
    {
        return view('contributorPanel::list.activity');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postList()
    {
        return view('contributorPanel::list.post');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postCreate()
    {
        return view('contributorPanel::post-creation');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postEdit(Post $post)
    {
        return view('contributorPanel::post-edit', compact('post'));
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profileEdit()
    {
        return view('contributorPanel::profile-edit');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postWaitList()
    {
        return view('contributorPanel::list.wait-post');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postRejectedList()
    {
        return view('contributorPanel::list.rejected-post');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postDetail($post)
    {
        $postId = $post;

        return view('contributorPanel::details.post', compact('postId'));
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forgetPassword()
    {
        return view('contributorPanel::forget-password');
    }
}
