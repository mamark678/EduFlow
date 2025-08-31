<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forum_post_id',
        'parent_id',
        'content',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_id');
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
        return 'id';
    }

    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    public function getDepthAttribute()
    {
        $depth = 0;
        $comment = $this;
        
        while ($comment->parent) {
            $depth++;
            $comment = $comment->parent;
        }
        
        return $depth;
    }

    public function markAsEdited()
    {
        $this->update([
            'is_edited' => true,
            'edited_at' => now(),
        ]);
    }
} 