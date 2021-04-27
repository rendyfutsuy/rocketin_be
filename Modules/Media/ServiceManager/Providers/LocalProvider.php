<?php

namespace Modules\Media\ServiceManager\Providers;

use Carbon\Carbon;
use Modules\Media\Models\Media;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Http\Resources\StorageResource;
use Modules\Media\ServiceManager\Contracts\StorageContract;

class LocalProvider implements StorageContract
{
    /** @var StorageResource */
    protected $return;

    /** @var Storage */
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function create(array $forms): self
    {
        $filePath = $this->getFilePath($forms['file'], '/'. auth()->id() . '/media/image');
        $this->return = Media::create([
            'user_id' => auth()->id(),
            'wp_media_id' => null,
            'source_url' => Storage::disk('public')->url($filePath),
            'title' => Carbon::now()->format('YmdHis'). '-' .$forms['file']->getClientOriginalName(),
            'description' => $forms['description'],
            'media_type' => 'image',
            'caption' => $forms['caption'],
            'alt_text' => $forms['alt_text'],
            'meta' => [],
            'media_detail' => null,
        ]);

        return $this;
    } 


    public function update(int $mediaId, array $forms): self
    {
        $response = $this->response->updateMedia(
            $mediaId,
            $forms,
            $this->token
        );

        $media = new EditWordpress($response);

        Media::where('id', $mediaId)
            ->update($media->render());

        $this->return = Media::where('id', $mediaId)->first();
        
        return $this;
    } 


    public function delete(int $mediaId): self
    {
        $media = Media::where('id', $mediaId)->first();

        $this->return = $media;

        $media->delete();

        return $this;
    } 

    public function return(): Media
    {
        return $this->return;
    }

    protected function getFilePath($file = null, $prefix = null): ?string
    {        
        if (! $file) {
            return null;
        }

        return $file ? Storage::disk('public')->put($prefix, $file) : ' ';
    }
}