<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'content',
        'order',
        'is_published',
        'support_file_path',
        'support_file_name',
        'support_file_type',
        'support_file_size',
        'video_type',
        'video_path',
        'video_url',
        'video_source',
        'video_creator',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Get the course that owns the module.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the videos for the module.
     */
    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('order');
    }

    /**
     * Get the documents for the module.
     */
    public function documents()
    {
        return $this->hasMany(Document::class)->orderBy('order');
    }

    /**
     * Get the comments for the module.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the progresses for the module.
     */
    public function progresses()
    {
        return $this->hasMany(\App\Models\ModuleProgress::class);
    }

    /**
     * Scope a query to only include published modules.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order modules by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Convert YouTube URL to embed URL for iframe embedding.
     */
    public function getEmbedVideoUrlAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        // Extract video ID from various YouTube URL formats
        $videoId = null;
        
        // Handle youtube.com/watch?v=VIDEO_ID format
        if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }
        // Handle youtu.be/VIDEO_ID format
        elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }
        // Handle youtube.com/embed/VIDEO_ID format (already embed)
        elseif (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }
        // Handle youtube.com/v/VIDEO_ID format
        elseif (preg_match('/youtube\.com\/v\/([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        // If it's not a YouTube URL, return the original URL
        return $this->video_url;
    }
}
