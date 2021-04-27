<?php

namespace Modules\Post\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResourceDetail extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'featured_media_id' => $this->featured_media,
            'featured_media' => $this->featured_url,
            'content' => str_replace($this->raw_description, nl2br($this->raw_description), $this->content),
            'gallery' => $this->gallery,
            'captions' => $this->captions,
            'location' => $this->location,
            'raw_description' => nl2br($this->raw_description),
            'raw_contact' => $this->raw_contact,
            'media' => $this->medias,
            'categories' => $this->categories,
            'tags' => $this->tags,
            'is_published' => $this->isPublished(),
            'is_rejected' => $this->isRejected(),
            'wp_post_id' => $this->wp_post_id,
            'publish_url' => route('api.post.publish', $this->id),
            'update_url' => route('api.post.update', $this->id),
            'wp_url' => $this->getWpUrl(),
        ];
    }
}
