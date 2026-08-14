<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Events\CommentApproved;
use BinshopsBlog\Events\CommentWillBeDeleted;
use BinshopsBlog\Helpers;
use BinshopsBlog\Models\BinshopsBlogComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class BinshopsBlogCommentsAdminController
 */
class BinshopsBlogCommentsAdminController extends Controller
{
    /**
     * Show all comments (and show buttons with approve/delete)
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $comments = BinshopsBlogComment::withoutGlobalScopes()->orderBy('created_at', 'desc')
            ->with('post');

        if ($request->input('waiting_for_approval')) {
            $comments->where('approved', false);
        }

        $comments = $comments->paginate(100);

        return view('binshopsblog_admin::comments.index')
            ->withComments($comments
            );
    }

    /**
     * Approve a comment
     *
     * @return RedirectResponse
     */
    public function approve($blogCommentId)
    {
        $comment = BinshopsBlogComment::withoutGlobalScopes()->findOrFail($blogCommentId);
        $comment->approved = true;
        $comment->save();

        Helpers::flash_message('Approved!');
        event(new CommentApproved($comment));

        return back();

    }

    /**
     * Delete a submitted comment
     *
     * @return RedirectResponse
     */
    public function destroy($blogCommentId)
    {
        $comment = BinshopsBlogComment::withoutGlobalScopes()->findOrFail($blogCommentId);
        event(new CommentWillBeDeleted($comment));

        $comment->delete();

        Helpers::flash_message('Deleted!');

        return back();
    }
}
