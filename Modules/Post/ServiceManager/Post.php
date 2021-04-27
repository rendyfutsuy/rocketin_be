<?php

namespace Modules\Post\ServiceManager;

use Modules\Auth\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Modules\Post\Models\Post as PostModel;
use Modules\Wordpress\ServiceManager\Wordpress;

class Post
{
    /** @var Wordpress */
    protected $wordpress;

    public function __construct(Wordpress $wordpress)
    {
        $this->wordpress = $wordpress;
    }

    public function publish(PostModel $post)
    {
        $forms = array_merge($post->only([
            'title',
            'slug',
            'content',
            'excerpt',
            'comment_status',
            'categories',
            'tags',
            'featured_media',
        ]), [
            'status' => PostModel::PUBLISHED,
        ]);

        $token = auth()->user()->getToken();
        $post->published_at = Carbon::now();
        $post->save();
        
        if (empty($post->wp_post_id)) {
            return $this->wordpress->requestCreatePost($token, $forms);
        }

        return $this->wordpress->requestUpdatePost($post->wp_post_id, $token, $forms);
    }

    public function delete(PostModel $post)
    {
        $token = auth()->user()->getToken();

        if (! empty($post->wp_post_id)) {
            $this->wordpress->requestDeletePost($post->wp_post_id, $token);
        }
        
        $post->wp_post_id = null;
        $post->status = PostModel::DELETE;
        $post->save();

        $post->delete();

        return $post;
    }

    public function rejectedToWaitList(PostModel $post): bool
    {
        if ($post->isPublished()) {
            return false;
        }

        if ($post->canNotPublish()) {
            return false;
        }

        return true;
    }

    public function readyToPublish(PostModel $post): bool
    {
        if ($post->isPublished()) {
            return false;
        }

        if ($post->canNotPublish()) {
            return false;
        }

        if (auth()->user()->canNotPublishPost()) {
            return false;
        }

        return true;
    }

    public function failToPublishText(PostModel $post): ?JsonResponse
    {
        if ($post->isPublished()) {
            return response()->json([
                'message' => __('post::crud.already_published', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ], 403);
        }

        if ($post->canNotPublish()) {
            return response()->json([
                'message' => __('post::crud.forbidden_to_publish', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ], 403);
        }

        if (auth()->user()->canNotPublishPost()) {
            return response()->json([
                'message' => __('post::crud.not_editor', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ], 403);
        }

        return null;
    }

    public function isOwner(PostModel $post): bool
    {
        if (auth()->user()->level == User::EDITOR) {
            return true;
        }

        if (auth()->user()->level == User::ADMIN) {
            return true;
        }

        return auth()->id() == $post->user_id;
    }
}