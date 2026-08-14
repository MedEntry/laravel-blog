<?php

namespace BinshopsBlog\Models;

use BinshopsBlog\Baum\Node;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class BinshopsBlogCategory extends Node
{
    protected $parentColumn = 'parent_id';

    public Collection $siblings;

    public $fillable = [
        'category_name',
        'slug',
        'category_description',
        'parent_id',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(BinshopsBlogPost::class, 'binshops_blog_post_categories');
    }

    /**
     * Returns the public-facing URL of showing blog posts in this category
     */
    public function url(): string
    {
        $theChainString = '';
        $chain = $this->getAncestorsAndSelf();
        foreach ($chain as $category) {
            $theChainString .= '/'.$category->slug;
        }

        return route('binshopsblog.view_category', $theChainString);
    }

    /**
     * Returns the URL for an admin user to edit this category
     */
    public function edit_url(): string
    {
        return route('binshopsblog.admin.categories.edit_category', $this->id);
    }

    public function loadSiblings(): void
    {
        $this->siblings = $this->children()->get();
    }

    //    public function parent()
    //    {
    //        return $this->belongsTo('BinshopsBlog\Models\BinshopsBlogCategory', 'parent_id');
    //    }
    //
    //    public function children()
    //    {
    //        return $this->hasMany('BinshopsBlog\Models\BinshopsBlogCategory', 'parent_id');
    //    }
    //
    //    // recursive, loads all descendants
    //    private function childrenRecursive()
    //    {
    //        return $this->children()->with('children')->get();
    //    }
    //
    //    public function loadChildren(){
    //        $this->childrenCat = $this->childrenRecursive();
    //    }

    //    public function scopeApproved($query)
    //    {
    //        dd("A");
    //        return $query->where("approved", true);
    //    }
}
