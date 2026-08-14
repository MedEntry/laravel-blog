<?php

namespace BinshopsBlog\Events;

use BinshopsBlog\Models\BinshopsBlogCategory;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class CategoryAdded
 */
class CategoryAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BinshopsBlogCategory $BinshopsBlogCategory;

    /**
     * CategoryAdded constructor.
     */
    public function __construct(BinshopsBlogCategory $BinshopsBlogCategory)
    {
        $this->BinshopsBlogCategory = $BinshopsBlogCategory;
    }
}
