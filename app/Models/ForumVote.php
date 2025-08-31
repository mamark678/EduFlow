<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'votable_type',
        'votable_id',
        'vote_type', // 'upvote' or 'downvote'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votable()
    {
        return $this->morphTo();
    }

    public function scopeUpvotes($query)
    {
        return $query->where('vote_type', 'upvote');
    }

    public function scopeDownvotes($query)
    {
        return $query->where('vote_type', 'downvote');
    }
} 