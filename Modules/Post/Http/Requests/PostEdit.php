<?php

namespace Modules\Post\Http\Requests;

use Modules\Post\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Post\Http\Requests\PostCreation;

class PostEdit extends PostCreation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'title'  => 'sometimes|nullable',
        ], parent::rules());
    }

    public function formInput(): array
    {
        $images = $this->get('images', []);
        $location = $this->location ?? 'Indonesia';
        $captions = $this->captions;
        $content = $this->description;
        $contact = $this->contact;
        $featuredUrl = $this->featured_url;
        $contacts = $this->contacts ?? [];
        $imageIds = $this->image_ids ?? [];

        return [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'content' => view('post::temp', compact('location', 'images', 'content', 'captions', 'contact', 'featuredUrl', 'contacts')),
            'raw_content' => [
                'featured_url' => $this->featured_url,
                'description' => $this->description,
                'contact' => normalize_words($this->contact),
                'images' => $this->images ?? [],
                'captions' => $this->captions ?? [],
                'contacts' => $contacts,
                'image_ids' => $imageIds,
                'location' => normalize_words($this->location),
            ],
            'excerpt' => $this->excerpt,
            'categories' => array_merge($this->categories ?? [], $this->location_id ? [
                $this->location_id,
            ] : []),
            'tags' => array_merge($this->tags ?? [], $this->location_id ? [
                $this->location_id,
            ] : []),
            'featured_media' => $this->featured_media,
            'status' => Post::DRAFTED,
        ];
    }
}