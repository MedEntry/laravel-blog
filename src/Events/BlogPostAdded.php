<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogPost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class BlogPostAdded
 */
class BlogPostAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogPost $BinshopsBlogPost;

    /**
     * BlogPostAdded constructor.
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost)
    {
        $this->BinshopsBlogPost = $BinshopsBlogPost;
    }
}
