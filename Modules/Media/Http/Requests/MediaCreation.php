<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaCreation extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file'  => [
                'required',
                'image',
                'max:10024',
            ],
        ];
    }

    public function formInput(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'media_type' => 'image',
            'caption' => $this->caption,
            'alt_text' => $this->alt_text,
            'file' => $this->file,
        ];
    }

}