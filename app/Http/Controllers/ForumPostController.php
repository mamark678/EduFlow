<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumPostController extends Controller
{
    public function show(ForumPost $post)
    {
        // Increment view count
        $post->incrementViews();
        
        // Load comments with replies
        $comments = $post->topLevelComments()
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Get related posts
        $relatedPosts = ForumPost::where('forum_id', $post->forum_id)
            ->where('id', '!=', $post->id)
            ->limit(5)
            ->with(['user', 'forum'])
            ->get();

        return view('forum.posts.show', compact('post', 'comments', 'relatedPosts'));
    }

    public function edit(ForumPost $post)
    {
        $this->authorize('update', $post);
        
        $forums = \App\Models\Forum::active()->ordered()->get();
        return view('forum.posts.edit', compact('post', 'forums'));
    }

    public function update(Request $request, ForumPost $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:300',
            'content' => 'required|string|max:10000',
            'type' => 'required|in:text,link,image,video',
            'link_url' => 'nullable|url|required_if:type,link',
            'image' => 'nullable|image|max:10240',
            'video_url' => 'nullable|url|required_if:type,video',
            'is_nsfw' => 'boolean',
        ]);

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'link_url' => $validated['link_url'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'is_nsfw' => $validated['is_nsfw'] ?? false,
        ]);

        // Handle image upload
        if ($request->hasFile('image') && $validated['type'] === 'image') {
            // Delete old image if exists
            if ($post->image_path) {
                \Storage::disk('public')->delete($post->image_path);
            }
            
            $path = $request->file('image')->store('forum/images', 'public');
            $post->update(['image_path' => $path]);
        }

        return redirect()->route('forum.posts.show', $post)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(ForumPost $post)
    {
        $this->authorize('delete', $post);

        // Delete associated image if exists
        if ($post->image_path) {
            \Storage::disk('public')->delete($post->image_path);
        }

        $forum = $post->forum;
        $post->delete();

        return redirect()->route('forum.show', $forum)
            ->with('success', 'Post deleted successfully!');
    }

    public function lock(ForumPost $post)
    {
        $this->authorize('moderate', $post);
        
        $post->update(['is_locked' => true]);
        return back()->with('success', 'Post locked successfully!');
    }

    public function unlock(ForumPost $post)
    {
        $this->authorize('moderate', $post);
        
        $post->update(['is_locked' => false]);
        return back()->with('success', 'Post unlocked successfully!');
    }

    public function pin(ForumPost $post)
    {
        $this->authorize('moderate', $post);
        
        $post->update(['is_pinned' => true]);
        return back()->with('success', 'Post pinned successfully!');
    }

    public function unpin(ForumPost $post)
    {
        $this->authorize('moderate', $post);
        
        $post->update(['is_pinned' => false]);
        return back()->with('success', 'Post unpinned successfully!');
    }
} 