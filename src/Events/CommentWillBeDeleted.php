<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogComment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CommentWillBeDeleted
 */
class CommentWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogComment $comment;

    /**
     * CommentWillBeDeleted constructor.
     */
    public function __construct(BinshopsBlogComment $comment)
    {
        $this->comment = $comment;
    }
}
