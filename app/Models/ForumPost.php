<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forum_id',
        'title',
        'content',
        'slug',
        'type',
        'link_url',
        'image_path',
        'video_url',
        'is_pinned',
        'is_locked',
        'is_nsfw',
        'views',
        'comments_count',
        'last_activity_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'is_nsfw' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            $post->last_activity_at = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class);
    }

    public function topLevelComments()
    {
        return $this->hasMany(ForumComment::class)->whereNull('parent_id');
    }

    public function votes()
    {
        return $this->morphMany(ForumVote::class, 'votable');
    }

    public function upvotes()
    {
        return $this->morphMany(ForumVote::class, 'votable')->where('vote_type', 'upvote');
    }

    public function downvotes()
    {
        return $this->morphMany(ForumVote::class, 'votable')->where('vote_type', 'downvote');
    }

    public function userVote()
    {
        if (!auth()->check()) {
            return null;
        }
        
        return $this->votes()->where('user_id', auth()->id())->first();
    }

    public function getScoreAttribute()
    {
        return $this->upvotes - $this->downvotes;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function updateLastActivity()
    {
        $this->update(['last_activity_at' => now()]);
    }

    // Scopes for filtering posts
    public function scopeNotLocked($query)
    {
        return $query->where('is_locked', false);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeHot($query)
    {
        // Hot posts based on recent activity and engagement
        return $query->orderBy('last_activity_at', 'desc')
                    ->orderBy('views', 'desc')
                    ->orderBy('comments_count', 'desc');
    }

    public function scopeNew($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeTop($query)
    {
        // Top posts based on views and comments
        return $query->orderBy('views', 'desc')
                    ->orderBy('comments_count', 'desc')
                    ->orderBy('created_at', 'desc');
    }
} 