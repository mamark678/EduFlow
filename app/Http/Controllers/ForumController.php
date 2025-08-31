<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\ForumPost;
use App\Models\ForumModerator;
use App\Models\ForumMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::active()->ordered()->withCount(['posts', 'comments'])->get();
        
        // Get recent posts for the sidebar
        $recentPosts = ForumPost::with(['user', 'forum'])
            ->notLocked()
            ->latest()
            ->limit(10)
            ->get();
            
        // Get trending posts
        $trendingPosts = ForumPost::with(['user', 'forum'])
            ->notLocked()
            ->hot()
            ->limit(5)
            ->get();

        return view('forum.index', compact('forums', 'recentPosts', 'trendingPosts'));
    }

    public function show(Forum $forum)
    {
        $sort = request('sort', 'hot');
        
        //dd($forum->id);
    $posts = ForumPost::where('forum_id', $forum->id)
        ->with(['user']) // no need to eager-load 'comments' anymore
        ->withCount('comments') // this adds 'comments_count'
        ->notLocked();

        switch ($sort) {
            case 'new':
                $posts = $posts->new();
                break;
            case 'top':
                $posts = $posts->top();
                break;
            case 'hot':
                $posts = $posts->hot();
                break;
            default:
                $posts = $posts->hot();
                break;
        }
        
        $posts = $posts->paginate(20);
        
        // Get pinned posts
        $pinnedPosts = ForumPost::where('forum_id', $forum->id)
            ->pinned()
            ->with(['user', 'comments'])
            ->get();

        return view('forum.show', compact('forum', 'posts', 'pinnedPosts', 'sort'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:forums,name',
            'description' => 'required|string|max:500',
            'rules' => 'nullable|string|max:2000',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ]);

        $forum = Forum::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'slug' => Str::slug($validated['name']),
            'rules' => $validated['rules'] ?? null,
            'icon' => $validated['icon'] ?? '💬',
            'color' => $validated['color'] ?? '#3b82f6',
            'created_by_user_id' => Auth::id(),
            'is_active' => true,
            'member_count' => 1, // Creator is the first member
        ]);

        // Make the creator a moderator with full permissions
        ForumModerator::create([
            'forum_id' => $forum->id,
            'user_id' => Auth::id(),
            'permissions' => ['moderate_posts', 'moderate_comments', 'manage_forum', 'appoint_moderators'],
            'appointed_by_user_id' => Auth::id(),
        ]);

        // Add creator as a member
        ForumMember::create([
            'forum_id' => $forum->id,
            'user_id' => Auth::id(),
            'role' => 'creator',
        ]);

        return redirect()->route('forum.show', $forum)
            ->with('success', 'Forum created successfully! You are now the moderator.');
    }

    public function createPost()
    {
        $forums = Forum::active()->ordered()->get();
        return view('forum.create-post', compact('forums'));
    }

    public function storePost(Request $request)
    {
        $rules = [
            'forum_id' => 'required|exists:forums,id',
            'title' => 'required|string|max:300',
            'type' => 'required|in:text,link,image,video',
            'link_url' => 'nullable|url|required_if:type,link',
            'image' => 'nullable|image|max:10240|required_if:type,image', // 10MB max
            'video_url' => 'nullable|url|required_if:type,video',
            'is_nsfw' => 'boolean',
        ];
        // Content required only for text posts
        if ($request->input('type', 'text') === 'text') {
            $rules['content'] = 'required|string|max:10000';
        } else {
            $rules['content'] = 'nullable|string|max:10000';
        }

        $validated = $request->validate($rules);

        // Generate a unique slug for the post within the forum
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (ForumPost::where('slug', $slug)->where('forum_id', $validated['forum_id'])->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $post = new ForumPost([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'link_url' => $validated['link_url'] ?? null,
            'video_url' => $validated['video_url'] ?? null,
            'is_nsfw' => $validated['is_nsfw'] ?? false,
            'slug' => $slug,
        ]);

        $post->user()->associate(Auth::user());
        $post->forum()->associate(Forum::find($validated['forum_id']));

        // Handle image upload
        if ($request->hasFile('image') && $validated['type'] === 'image') {
            $path = $request->file('image')->store('forum/images', 'public');
            $post->image_path = $path;
        }

        $post->save();

        return redirect()->route('forum.posts.show', $post)
            ->with('success', 'Post created successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $forum = $request->get('forum');
        $sort = $request->get('sort', 'relevance');

        // Search posts
        $posts = ForumPost::with(['user', 'forum', 'comments'])
            ->notLocked();

        if ($query) {
            $posts = $posts->where(function ($q2) use ($query) {
                $q2->where('title', 'like', "%{$query}%")
                   ->orWhere('content', 'like', "%{$query}%");
            });
        }

        if ($forum) {
            $posts = $posts->where('forum_id', $forum);
        }

        switch ($sort) {
            case 'new':
                $posts = $posts->new();
                break;
            case 'top':
                $posts = $posts->top();
                break;
            case 'hot':
                $posts = $posts->hot();
                break;
            case 'relevance':
            default:
                $posts = $posts->orderByRaw('(upvotes - downvotes) + (TIMESTAMPDIFF(HOUR, created_at, NOW()) * -0.1) DESC');
                break;
        }

        $posts = $posts->paginate(20);

        // Search forums by name/description
        $forumResults = collect();
        if ($query) {
            $forumResults = Forum::active()->where(function($q2) use ($query) {
                $q2->where('name', 'like', "%{$query}%")
                   ->orWhere('description', 'like', "%{$query}%");
            })->ordered()->get();
        }

        $forums = Forum::active()->ordered()->get();

        return view('forum.search', compact('posts', 'forums', 'forumResults', 'query', 'forum', 'sort'));
    }
} 