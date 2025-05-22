<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $article = Article::findOrFail($articleId);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = Auth::id();
        $comment->article_id = $article->id;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    /**
     * Update the specified comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        // Check if user is authorized to update this comment
        $this->authorize('update', $comment);

        $comment->body = $request->body;
        $comment->save();

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        // Check if user is authorized to delete this comment
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
