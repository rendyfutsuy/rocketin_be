<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Post\Events\PostWaited;
use App\Http\Controllers\Controller;
use Modules\Post\Events\PostCreated;
use Modules\Post\Events\PostDeleted;
use Modules\Post\Events\PostUpdated;
use Modules\Post\Events\PostRejected;
use Modules\Post\Events\PostPublished;
use Modules\Post\Http\Requests\PostEdit;
use Modules\Post\Http\Requests\PostWait;
use Modules\Post\Http\Searches\PostSearch;
use Modules\Post\Http\Requests\PostCreation;
use Modules\Wordpress\ServiceManager\Wordpress;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Post\Http\Resources\PostResourceDetail;
use Modules\Post\ServiceManager\Post as PostManager;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Post\Http\Resources\PostResourceCollection;

class VideoController extends Controller
{
    /** @var Wordpress */
    protected $wordpress;

    /** @var PostsSearch */
    protected $search;
    
    /** @var PostManager */
    protected $post;

    public function __construct(Wordpress $wordpress, PostSearch $search, PostManager $post)
    {
        $this->wordpress = $wordpress;
        $this->search= $search;
        $this->post = $post;
    }
    
    public function save(PostCreation $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $post = Post::create($request->formInput());
            
            event('post_created', new PostCreated($post, $request));

            return response()->json([
                'message' => __('post::crud.saved', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function update(Post $post, PostEdit $request): JsonResponse
    {
        return DB::transaction(function () use ($request, $post) {
            if (! $this->post->isOwner($post)) {
                return response()->json([
                    'message' => __('post::crud.can_not_update_post', [], auth()->user()->getLocale()),
                ], 403);
            }

            $previous = clone $post;

            $post->update($request->formInput());

            event('post_updated', new PostUpdated($previous, $post->refresh(), $request));

            return response()->json([
                'message' => __('post::crud.updated', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function delete(Post $post): JsonResponse
    {
        return DB::transaction(function () use ($post) {
            if (! $this->post->isOwner($post)) {
                return response()->json([
                    'message' => __('post::crud.can_not_delete_post', [], auth()->user()->getLocale()),
                ], 403);
            }

            $response = $this->post->delete($post);

            event('post_deleted', new PostDeleted($post));

            return response()->json([
                'message' => __('post::crud.deleted', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function toRejectedList(Post $post, Request $request): JsonResponse
    {
        return DB::transaction(function () use ($post, $request) {

            if ($post->status == Post::REJECTED) {
                return response()->json([
                    'message' => __('post::crud.already_rejected', [
                        'title' => $post->title,
                    ], auth()->user()->getLocale()),
                ]);
            }
            
            $post->status = Post::REJECTED;

            if ($request->note) {
                $post->meta = array_merge($post->meta ?? [], [
                    'rejected_note' => $request->note,
                ]);
            }
            
            $post->save();

            event('post_rejected', new PostRejected($post, $request));

            return response()->json([
                'message' => __('post::crud.rejected', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function toWaitList(Post $post, PostWait $request): JsonResponse
    {
        return DB::transaction(function () use ($post, $request) {
            if (!empty($request->all())) {
                $post->update($request->formInput());
            }

            if (! $this->post->rejectedToWaitList($post)) {
                return $this->post->failToPublishText($post);
            }

            if ($post->status == Post::WAITED) {
                return response()->json([
                    'message' => __('post::crud.already_waited', [
                        'title' => $post->title,
                    ], auth()->user()->getLocale()),
                ]);
            }
            
            $post->status = Post::WAITED;
            $post->save();

            event('post_waited', new PostWaited($post));

            return response()->json([
                'message' => __('post::crud.waited', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }


    public function publish(Post $post): JsonResponse
    {
        return DB::transaction(function () use ($post) {
            if (! $this->post->readyToPublish($post)) {
                return $this->post->failToPublishText($post);
            }

            $response = $this->post->publish($post);
            
            $post->wp_post_id = $response->id;
            $post->status = Post::PUBLISHED;
            $post->save();

            event('post_published', new PostPublished($post));

            return response()->json([
                'message' => __('post::crud.published', [
                    'title' => $post->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function list(Request $request): ResourceCollection
    {
        $posts = $this->search->apply()->orderBy('id', $request->get('order_by', 'DESC'))->paginate($request->per_page ?? 5);

        return new PostResourceCollection($posts);
    }

    public function detail(Post $post): JsonResource
    {
        return new PostResourceDetail($post);
    }

    public function waitList(Request $request): ResourceCollection
    {
        $posts = $this->search->apply()
            ->where('status', Post::WAITED)
            ->orderBy('id', $request->get('order_by', 'DESC'))
            ->paginate($request->per_page ?? 5);


        return new PostResourceCollection($posts);
    }

    public function rejectedList(Request $request): ResourceCollection
    {
        $posts = $this->search->apply()
            ->where('status', Post::REJECTED)
            ->orderBy('updated_at', $request->get('order_by', 'DESC'))
            ->paginate($request->per_page ?? 5);


        return new PostResourceCollection($posts);
    }
}
