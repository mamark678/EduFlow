<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'user_id',
        'role',
        'joined_at',
        'is_active',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    public function isCreator()
    {
        return $this->role === 'creator';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }
} 