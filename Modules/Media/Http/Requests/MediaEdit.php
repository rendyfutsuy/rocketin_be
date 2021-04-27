<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Media\Http\Requests\MediaCreation;

class MediaEdit extends MediaCreation
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'file'  => 'sometimes',
        ]);
    }

    public function formInput(): array
    {
        return [
            'title' => $this->title ?? $this->route('media')->title,
            'description' => $this->description ?? $this->route('media')->description,
            'media_type' => 'image',
            'caption' => $this->caption ?? $this->route('media')->caption,
            'alt_text' => $this->alt_text ?? $this->route('media')->alt_text,
        ];
    }
}