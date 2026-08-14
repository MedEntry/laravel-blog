<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogComment;
use BinshopsBlog\Models\BinshopsBlogPost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CommentAdded
 */
class CommentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogPost $BinshopsBlogPost;

    public BinshopsBlogComment $newComment;

    /**
     * CommentAdded constructor.
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost, BinshopsBlogComment $newComment)
    {
        $this->BinshopsBlogPost = $BinshopsBlogPost;
        $this->newComment = $newComment;
    }
}
