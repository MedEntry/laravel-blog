<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogPost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class BlogPostEdited
 */
class BlogPostEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogPost $BinshopsBlogPost;

    /**
     * BlogPostEdited constructor.
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost)
    {
        $this->BinshopsBlogPost = $BinshopsBlogPost;
    }
}
