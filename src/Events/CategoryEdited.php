<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogCategory;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CategoryEdited
 */
class CategoryEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogCategory $BinshopsBlogCategory;

    /**
     * CategoryEdited constructor.
     */
    public function __construct(BinshopsBlogCategory $BinshopsBlogCategory)
    {
        $this->BinshopsBlogCategory = $BinshopsBlogCategory;
    }
}
