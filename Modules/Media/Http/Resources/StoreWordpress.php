<?php

namespace Modules\Media\Http\Resources;

use Modules\Media\Http\Resources\StorageResource;

class StoreWordpress extends StorageResource
{
    public function __construct(object $param)
    {
        $this->param = $param;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function render()
    {
        return [
            'user_id' => auth()->id(),
            'wp_media_id' => $this->param->id,
            'source_url' => $this->param->source_url,
            'title' => $this->param->title->raw,
            'description' => $this->param->description->raw,
            'media_type' => $this->param->media_type,
            'caption' => $this->param->caption->raw,
            'alt_text' => $this->param->alt_text,
            'meta' => $this->param->meta,
            'media_detail' => $this->param->media_details,
        ];
    }
}
