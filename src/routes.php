<?php

use BinshopsBlog\Controllers\BinshopsBlogAdminController;
use BinshopsBlog\Controllers\BinshopsBlogCategoryAdminController;
use BinshopsBlog\Controllers\BinshopsBlogCommentsAdminController;
use BinshopsBlog\Controllers\BinshopsBlogCommentWriterController;
use BinshopsBlog\Controllers\BinshopsBlogImageUploadController;
use BinshopsBlog\Controllers\BinshopsBlogReaderController;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {

    /** The main public-facing blog routes - show all posts, view a category, rss feed, view a single post, also the add comment route */
    Route::group(['prefix' => config('binshopsblog.blog_prefix', 'blog')], static function () {

        Route::get('/', [BinshopsBlogReaderController::class, 'index'])
            ->name('binshopsblog.index');

        Route::get('/search', [BinshopsBlogReaderController::class, 'search'])
            ->name('binshopsblog.search');

        //        Route::get('/feed', [\BinshopsBlog\Controllers\BinshopsBlogRssFeedController::class, 'feed'])
        //            ->name('binshopsblog.feed'); //RSS feed

        Route::get('/category{subcategories}', [BinshopsBlogReaderController::class, 'view_category'])
            ->where('subcategories', '^[a-zA-Z0-9-_\/]+$')->name('binshopsblog.view_category');

        //        Route::get('/category/{categorySlug}',
        //            [\BinshopsBlog\Controllers\BinshopsBlogReaderController::class,'view_category'])
        //            ->name('binshopsblog.view_category');

        Route::get('/{blogPostSlug}',
            [BinshopsBlogReaderController::class, 'viewSinglePost'])
            ->name('binshopsblog.single');

        // throttle to a max of 10 attempts in 3 minutes:
        Route::group(['middleware' => 'throttle:10,3'], static function () {

            Route::post('save_comment/{blogPostSlug}',
                [BinshopsBlogCommentWriterController::class, 'addNewComment'])
                ->name('binshopsblog.comments.add_new_comment');
        });
    });

    /* Admin backend routes - CRUD for posts, categories, and approving/deleting submitted comments */
    Route::group(['prefix' => config('binshopsblog.admin_prefix', 'blog_admin')], static function () {

        Route::get('/search',
            [BinshopsBlogAdminController::class, 'searchBlog'])
            ->name('binshopsblog.admin.searchblog');

        Route::get('/', [BinshopsBlogAdminController::class, 'index'])
            ->name('binshopsblog.admin.index');

        Route::get('/add_post',
            [BinshopsBlogAdminController::class, 'create_post'])
            ->name('binshopsblog.admin.create_post');

        Route::post('/add_post',
            [BinshopsBlogAdminController::class, 'store_post'])
            ->name('binshopsblog.admin.store_post');

        Route::get('/edit_post/{blogPostId}',
            [BinshopsBlogAdminController::class, 'edit_post'])
            ->name('binshopsblog.admin.edit_post');

        Route::patch('/edit_post/{blogPostId}',
            [BinshopsBlogAdminController::class, 'update_post'])
            ->name('binshopsblog.admin.update_post');

        // Removes post's photo
        Route::get('/remove_photo/{slug}',
            [BinshopsBlogAdminController::class, 'remove_photo'])
            ->name('binshopsblog.admin.remove_photo');

        Route::group(['prefix' => 'image_uploads'], static function () {

            Route::get('/', [BinshopsBlogImageUploadController::class, 'index'])->name('binshopsblog.admin.images.all');

            Route::get('/upload', [BinshopsBlogImageUploadController::class, 'create'])
                ->name('binshopsblog.admin.images.upload');
            Route::post('/upload', [BinshopsBlogImageUploadController::class, 'store'])
                ->name('binshopsblog.admin.images.store');
        });

        Route::delete('/delete_post/{blogPostId}',
            [BinshopsBlogAdminController::class, 'destroy_post'])
            ->name('binshopsblog.admin.destroy_post');

        Route::group(['prefix' => 'comments'], static function () {

            Route::get('/',
                [BinshopsBlogCommentsAdminController::class, 'index'])
                ->name('binshopsblog.admin.comments.index');

            Route::patch('/{commentId}',
                [BinshopsBlogCommentsAdminController::class, 'approve'])
                ->name('binshopsblog.admin.comments.approve');
            Route::delete('/{commentId}',
                [BinshopsBlogCommentsAdminController::class, 'destroy'])
                ->name('binshopsblog.admin.comments.delete');
        });

        Route::group(['prefix' => 'categories'], static function () {

            Route::get('/',
                [BinshopsBlogCategoryAdminController::class, 'index'])
                ->name('binshopsblog.admin.categories.index');

            Route::get('/add_category',
                [BinshopsBlogCategoryAdminController::class, 'create_category'])
                ->name('binshopsblog.admin.categories.create_category');
            Route::post('/add_category',
                [BinshopsBlogCategoryAdminController::class, 'store_category'])
                ->name('binshopsblog.admin.categories.store_category');

            Route::get('/edit_category/{categoryId}',
                [BinshopsBlogCategoryAdminController::class, 'edit_category'])
                ->name('binshopsblog.admin.categories.edit_category');

            Route::patch('/edit_category/{categoryId}',
                [BinshopsBlogCategoryAdminController::class, 'update_category'])
                ->name('binshopsblog.admin.categories.update_category');

            Route::delete('/delete_category/{categoryId}',
                [BinshopsBlogCategoryAdminController::class, 'destroy_category'])
                ->name('binshopsblog.admin.categories.destroy_category');
        });
    })->middleware(UserCanManageBlogPosts::class);
});
