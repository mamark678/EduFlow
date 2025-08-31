<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ForumPost;

class ForumPostPolicy
{
    public function update(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id || $user->isAdmin();
    }

    public function delete(User $user, ForumPost $post): bool
    {
        return $user->id === $post->user_id || $user->isAdmin();
    }

    public function moderate(User $user, ForumPost $post): bool
    {
        return $user->isAdmin() || $user->isInstructor();
    }
} 