<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogPost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UploadedImage
 */
class UploadedImage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?BinshopsBlogPost $BinshopsBlogPost;

    public $image;

    public ?string $source;

    public string $image_filename;

    /**
     * UploadedImage constructor.
     *
     * @param  $image_filename  - the new filename
     * @param  $source  string|null  the __METHOD__  firing this event (or other string)
     */
    public function __construct(string $image_filename, $image, ?BinshopsBlogPost $BinshopsBlogPost = null, string $source = 'other')
    {
        $this->image_filename = $image_filename;
        $this->BinshopsBlogPost = $BinshopsBlogPost;
        $this->image = $image;
        $this->source = $source;
    }
}
