<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Media\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Media\Events\MediaCreated;
use Modules\Media\Events\MediaDeleted;
use Modules\Media\Events\MediaUpdated;
use Modules\Media\ServiceManager\Image;
use Modules\Media\Events\MediaPublished;
use Modules\Media\Http\Requests\MediaEdit;
use Modules\Media\Http\Searches\MediaSearch;
use Modules\Media\Http\Resources\MediaDetail;
use Modules\Media\Http\Requests\MediaCreation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Modules\Media\Http\Resources\MediaResourceCollection;

class MediaController extends Controller
{
    /** @var Image */
    protected $image;

    /** @param MediaSearch */
    protected $search;

    public function __construct(Image $image, MediaSearch $search)
    {
        $this->image = $image;
        $this->search = $search;
    }
    
    public function save(MediaCreation $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $media = $this->image->create($request->formInput())->return();
                        
            event('media_created', new MediaCreated($media));

            return response()->json([
                'message' => __('media::crud.saved', [], auth()->user()->getLocale()),
                'media' => $media->only(['id', 'source_url', 'title', 'caption', 'wp_media_id']),
            ]);
        });
    }

    public function update(Media $media, MediaEdit $request): JsonResponse
    {
        return DB::transaction(function () use ($request, $media) {
            $media = $this->image->update($media->wp_media_id, $request->formInput())->return();
            
            event('media_updated', new MediaUpdated($media, $request));

            return response()->json([
                'message' => __('media::crud.updated', [], auth()->user()->getLocale()),
                'media' => $media->only(['id', 'source_url', 'title', 'caption']),
            ]);
        });
    }

    public function delete(Media $media): JsonResponse
    {
        return DB::transaction(function () use ($media) {
            $media = $this->image->delete($media->wp_media_id)->return();

            event('media_deleted', new MediaDeleted($media));

            return response()->json([
                'message' => __('media::crud.deleted', [], auth()->user()->getLocale()),
                'media' => $media->only(['id', 'source_url', 'title', 'caption']),
            ]);
        });
    }

    public function list(Request $request): ResourceCollection
    {
        $medias = $this->search->apply()->paginate($request->per_page ?? 5);

        return new MediaResourceCollection($medias);
    }

    public function detail(Media $media): JsonResource
    {
        return new MediaDetail($media);
    }
}