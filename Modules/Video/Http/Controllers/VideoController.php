<?php

namespace Modules\Video\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Video\Models\Video;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\Video as VideoResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoController extends Controller
{
    public function save(Request $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $url = null;

            if ($this->request->file) {
                $prefix = 'videos/'. auth()->user()->id .'/';

                $file = $this->request->file;

                $url = Storage::put('public/'.$prefix, $file) ?? ' ';
            }

            $video = Post::create(array_merge([
                'watch_url' => $url,
            ], $request->all()));
            
            // event('video_created', new VideoCreated($video, $request));

            return response()->json([
                'message' => __('video::crud.saved', [
                    'title' => $video->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function update(Video $video, Request $request): JsonResponse
    {
        return DB::transaction(function () use ($request, $video) {
            $previous = clone $video;
            $url = $previous->watch_url;

            if ($this->request->file) {
                $prefix = 'videos/'. auth()->user()->id .'/';
                
                $file = $this->request->file;

                $url = Storage::put('public/'.$prefix, $file) ?? ' ';
            }

            $video->update(array_merge([
                'watch_url' => $url,
            ], $request->all()));

            // event('video_updated', new VideoUpdated($previous, $video->refresh(), $request));

            return response()->json([
                'message' => __('video::crud.updated', [
                    'title' => $video->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function delete(Video $video): JsonResponse
    {
        return DB::transaction(function () use ($video) {
            if (! $this->post->isOwner($video)) {
                return response()->json([
                    'message' => __('video::crud.can_not_delete_post', [], auth()->user()->getLocale()),
                ], 403);
            }

            $response = $this->post->delete($video);

            // event('video_deleted', new VideoDeleted($video));

            return response()->json([
                'message' => __('video::crud.deleted', [
                    'title' => $video->title,
                ], auth()->user()->getLocale()),
            ]);
        });
    }

    public function detail(Video $video): JsonResponse
    {
        return DB::transaction(function () use ($video) {
            if (! $this->post->isOwner($video)) {
                return response()->json([
                    'message' => __('video::crud.can_not_delete_post', [], auth()->user()->getLocale()),
                ], 403);
            }

            $response = $this->post->delete($video);

            // event('video_deleted', new VideoDeleted($video));

            return new VideoResource($video);
        });
    }

    public function list(Request $request): ResourceCollection
    {
        $videos = Video::query()
            ->orderBy('id', $request->get('order_by', 'DESC'))
            ->paginate($request->per_page ?? 5);


        return new VideoCollection($videos);
    }
}
