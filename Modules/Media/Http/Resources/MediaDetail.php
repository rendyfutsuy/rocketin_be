<?php

namespace Modules\Media\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uploader' => $this->user,
            'wp_media_id' => $this->wp_media_id,
            'source_url' => $this->source_url,
            'posts' => $this->posts,
            'title' => $this->title,
            'description' => $this->description,
            'media_type' => $this->media_type,
            'caption' => $this->caption,
            'alt_text' => $this->alt_text,
            'meta' => $this->meta,
            'media_detail' => $this->media_detail,
            'edit_url' => route('api.media.update', $this->id),
        ];
    }
}
