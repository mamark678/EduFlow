<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumCommentController extends Controller
{
    public function store(Request $request, ForumPost $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        if ($post->is_locked) {
            return back()->with('error', 'This post is locked and cannot be commented on.');
        }

        $comment = new ForumComment([
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        $comment->user()->associate(Auth::user());
        $comment->post()->associate($post);
        $comment->save();

        // Update post's comment count and last activity
        $post->increment('comments_count');
        $post->updateLastActivity();

        return back()->with('success', 'Comment posted successfully!');
    }

    public function edit(ForumComment $comment)
    {
        $this->authorize('update', $comment);
        
        return view('forum.comments.edit', compact('comment'));
    }

    public function update(Request $request, ForumComment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        $comment->markAsEdited();

        return redirect()->route('forum.posts.show', $comment->post)
            ->with('success', 'Comment updated successfully!');
    }

    public function destroy(ForumComment $comment)
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;
        
        // Decrement post's comment count
        $post->decrement('comments_count');
        
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
} 