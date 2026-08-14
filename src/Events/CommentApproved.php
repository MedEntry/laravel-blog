<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogComment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CommentApproved
 */
class CommentApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogComment $comment;

    /**
     * CommentApproved constructor.
     */
    public function __construct(BinshopsBlogComment $comment)
    {
        $this->comment = $comment;
        // you can get the blog post via $comment->post
    }
}
