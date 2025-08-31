<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumModerator extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'user_id',
        'permissions',
        'appointed_at',
        'appointed_by_user_id',
    ];

    protected $casts = [
        'appointed_at' => 'datetime',
        'permissions' => 'array',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointedBy()
    {
        return $this->belongsTo(User::class, 'appointed_by_user_id');
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }

    public function canModeratePosts()
    {
        return $this->hasPermission('moderate_posts');
    }

    public function canModerateComments()
    {
        return $this->hasPermission('moderate_comments');
    }

    public function canManageForum()
    {
        return $this->hasPermission('manage_forum');
    }

    public function canAppointModerators()
    {
        return $this->hasPermission('appoint_moderators');
    }
} 