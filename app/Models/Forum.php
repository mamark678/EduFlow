<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'icon',
        'color',
        'is_active',
        'order',
        'created_by_user_id',
        'rules',
        'banner_url',
        'member_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($forum) {
            if (empty($forum->slug)) {
                $forum->slug = Str::slug($forum->name);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function comments()
    {
        return $this->hasManyThrough(ForumComment::class, ForumPost::class);
    }

    public function publishedPosts()
    {
        return $this->hasMany(ForumPost::class)->where('is_locked', false);
    }

    public function pinnedPosts()
    {
        return $this->hasMany(ForumPost::class)->where('is_pinned', true);
    }

    public function moderators()
    {
        return $this->hasMany(ForumModerator::class);
    }

    public function members()
    {
        return $this->hasMany(ForumMember::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getTotalPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getTotalCommentsCountAttribute()
    {
        return $this->posts()->withSum('comments', 'comments_count')->sum('comments_count');
    }

    public function getLastActivityAttribute()
    {
        return $this->posts()->latest('last_activity_at')->first()?->last_activity_at;
    }
} 