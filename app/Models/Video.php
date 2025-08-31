<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'video_path',
        'video_url', // For external links (YouTube, Vimeo, etc.)
        'thumbnail_path',
        'duration',
        'order',
        'is_published',
        'video_type', // 'file' or 'url'
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
     * Get the module that owns the video.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Scope a query to only include published videos.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to order videos by their order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the formatted duration.
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return 'Unknown';
        }

        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    /**
     * Check if video is a file upload.
     */
    public function isFileUpload()
    {
        return $this->video_type === 'file' && $this->video_path;
    }

    /**
     * Check if video is an external URL.
     */
    public function isExternalUrl()
    {
        return $this->video_type === 'url' && $this->video_url;
    }

    /**
     * Get the video source (file path or URL).
     */
    public function getVideoSourceAttribute()
    {
        if ($this->isFileUpload()) {
            return route('courses.modules.videos.stream', [
                'course' => $this->module->course,
                'module' => $this->module,
                'video' => $this
            ]);
        }

        return $this->video_url;
    }

    /**
     * Get YouTube video ID from URL.
     */
    public function getYouTubeIdAttribute()
    {
        if (!$this->isExternalUrl()) {
            return null;
        }

        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $this->video_url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get Vimeo video ID from URL.
     */
    public function getVimeoIdAttribute()
    {
        if (!$this->isExternalUrl()) {
            return null;
        }

        $pattern = '/vimeo\.com\/([0-9]+)/i';
        if (preg_match($pattern, $this->video_url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
