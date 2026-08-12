<?php

namespace BinshopsBlog\Requests;

/**
 * Class BaseRequest
 */
class UploadImageRequest extends BaseRequest
{
    /**
     *  rules for uploads
     */
    public function rules(): array
    {
        return [
            'sizes_to_upload' => [
                'required',
                'array',
            ],
            'sizes_to_upload.*' => [
                'string',
                'max:100',
            ],
            'upload' => [
                'required',
                'image',
            ],
            'image_title' => [
                'required',
                'string',
                'min:1',
                'max:150',
            ],
        ];
    }
}
