<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumComment;

class ForumCommentPolicy
{
    public function update(User $user, ForumComment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }

    public function delete(User $user, ForumComment $comment): bool
    {
        return $user->id === $comment->user_id || $user->isAdmin();
    }
} 