<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::withCount(['posts', 'comments'])->ordered()->get();
        $totalPosts = ForumPost::count();
        $totalComments = ForumComment::count();
        $recentPosts = ForumPost::with(['user', 'forum'])->latest()->limit(10)->get();
        
        return view('instructor.forums.index', compact('forums', 'totalPosts', 'totalComments', 'recentPosts'));
    }

    public function create()
    {
        return view('instructor.forums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:forums,name',
            'description' => 'required|string|max:500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
        ]);

        $forum = Forum::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? '💬',
            'color' => $validated['color'] ?? '#3b82f6',
            'order' => $validated['order'] ?? 0,
            'is_active' => true,
        ]);

        return redirect()->route('instructor.forums.index')
            ->with('success', 'Forum created successfully!');
    }

    public function edit(Forum $forum)
    {
        return view('instructor.forums.edit', compact('forum'));
    }

    public function update(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:forums,name,' . $forum->id,
            'description' => 'required|string|max:500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $forum->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => Str::slug($validated['name']),
            'icon' => $validated['icon'] ?? '💬',
            'color' => $validated['color'] ?? '#3b82f6',
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('instructor.forums.index')
            ->with('success', 'Forum updated successfully!');
    }

    public function posts()
    {
        $posts = ForumPost::with(['user', 'forum'])
            ->latest()
            ->paginate(20);

        return view('instructor.forums.posts', compact('posts'));
    }

    public function moderatePost(ForumPost $post)
    {
        $action = request('action');
        
        switch ($action) {
            case 'lock':
                $post->update(['is_locked' => true]);
                $message = 'Post locked successfully!';
                break;
            case 'unlock':
                $post->update(['is_locked' => false]);
                $message = 'Post unlocked successfully!';
                break;
            case 'pin':
                $post->update(['is_pinned' => true]);
                $message = 'Post pinned successfully!';
                break;
            case 'unpin':
                $post->update(['is_pinned' => false]);
                $message = 'Post unpinned successfully!';
                break;
            case 'delete':
                $post->delete();
                $message = 'Post deleted successfully!';
                break;
            default:
                return back()->with('error', 'Invalid action.');
        }

        return back()->with('success', $message);
    }

    public function comments()
    {
        $comments = ForumComment::with(['user', 'post'])
            ->latest()
            ->paginate(20);

        return view('instructor.forums.comments', compact('comments'));
    }

    public function moderateComment(ForumComment $comment)
    {
        $action = request('action');
        
        switch ($action) {
            case 'delete':
                $comment->delete();
                $message = 'Comment deleted successfully!';
                break;
            default:
                return back()->with('error', 'Invalid action.');
        }

        return back()->with('success', $message);
    }
} 