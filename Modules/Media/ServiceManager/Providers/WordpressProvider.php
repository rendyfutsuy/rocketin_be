<?php

namespace Modules\Media\ServiceManager\Providers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Media\Models\Media;
use Illuminate\Support\Facades\Http;
use Modules\Media\Http\Resources\EditWordpress;
use Modules\Wordpress\ServiceManager\Wordpress;
use Modules\Media\Http\Resources\StoreWordpress;
use Modules\Media\Http\Resources\DeleteWordpress;
use Modules\Media\Http\Resources\StorageResource;
use Modules\Media\ServiceManager\Contracts\StorageContract;

class WordpressProvider implements StorageContract
{
    /** @var Wordpress */
    protected $response;

    /** @var StorageResource */
    protected $return;

    /** @var string */
    protected $token;

    public function __construct(Wordpress $response)
    {
        $this->response = $response;
        $this->token = base64_encode(config('wordpress.basic_auth_username') . ':' .config('wordpress.basic_auth_password'));
    }

    public function create(array $forms): self
    {        
        $response = $this->response->uploadMedia(
            $this->response->baseUrl() . '/wp/v2/media',
            $forms,
            $this->token,
        );
        
        $media = new StoreWordpress($response);

        $this->return = Media::create($media->render());

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

        Media::where('wp_media_id', $mediaId)->update($media->render());

        $this->return = Media::where('wp_media_id', $mediaId)->first();
        
        return $this;
    } 

    public function delete(int $mediaId): self
    {
        $response = $this->response->deleteMedia(
            $mediaId,
            $this->token
        );

        $media = Media::where('wp_media_id', $mediaId)->first();

        $this->return = $media;

        $media->delete();

        return $this;
    } 

    public function return(): Media
    {
        return $this->return;
    }
}