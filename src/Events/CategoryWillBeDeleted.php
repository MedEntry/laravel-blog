<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogCategory;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CategoryWillBeDeleted
 */
class CategoryWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogCategory $BinshopsBlogCategory;

    /**
     * CategoryWillBeDeleted constructor.
     */
    public function __construct(BinshopsBlogCategory $BinshopsBlogCategory)
    {
        $this->BinshopsBlogCategory = $BinshopsBlogCategory;
    }
}
