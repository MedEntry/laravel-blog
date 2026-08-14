<?php

namespace BinshopsBlog\Models;

use App\User;
use BinshopsBlog\Scopes\BlogCommentApprovedAndDefaultOrderScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BinshopsBlogComment extends Model
{
    public $fillable = [

        'comment',
        'author_name',
    ];

    public $casts = [
        'approved' => 'boolean',
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        /* If a user is logged in and \Auth::user()->canManageBinshopsBlogPosts() == true, show any/all posts.
           otherwise (which will be for most users) it should only show published posts that have a posted_at
           time <= Carbon::now(). This sets it up: */
        static::addGlobalScope(new BlogCommentApprovedAndDefaultOrderScope);
    }

    /**
     * The associated BinshopsBlogPost
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(BinshopsBlogPost::class, 'binshops_blog_post_id');
    }

    /**
     * Comment author user (if set)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('binshopsblog.user_model'), 'user_id');
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value
     */
    public function author(): string
    {
        if ($this->user_id) {
            $field = config('binshopsblog.comments.user_field_for_author_name', 'name');

            return optional($this->user)->$field;
        }

        return $this->author_name;
    }
}
