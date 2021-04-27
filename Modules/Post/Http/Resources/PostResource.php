<?php

namespace Modules\Post\Http\Resources;

use Modules\Post\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'is_published' => $this->isPublished(),
            'is_rejected' => $this->isRejected(),
            'status' => $this->status,
            'title' => $this->title,
            'featured_media' => $this->featured_url,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'tags' => $this->tags,
            'author' => $this->user->username,
            'categories' => $this->categories,
            'created_at' => $this->created_at->format('Y M d H:i:s'),
            'published_at' => $this->status == Post::PUBLISHED ? $this->published_at->format('Y M d H:i:s') : 'Belum dipublikasikan.',
            'detail_url' => route('api.post.detail', $this->id),
            'edit_url' => route('contributor.edit.post', $this->id),
            'publish_url' => route('api.post.publish', $this->id),
            'reject_url' => route('api.post.to.rejected.list', $this->id),
            'rejected_note' => $this->rejected_note,
            'wp_url' => $this->getWpUrl(),
        ];
    }
}
