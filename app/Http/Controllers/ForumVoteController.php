<?php

namespace App\Http\Controllers;

use App\Models\ForumVote;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumVoteController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'votable_type' => 'required|in:App\Models\ForumPost,App\Models\ForumComment',
            'votable_id' => 'required|integer',
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        $user = Auth::user();
        $votableType = $request->votable_type;
        $votableId = $request->votable_id;
        $voteType = $request->vote_type;

        // Get the votable model
        $votable = $votableType::findOrFail($votableId);

        // Check if user already voted
        $existingVote = ForumVote::where('user_id', $user->id)
            ->where('votable_type', $votableType)
            ->where('votable_id', $votableId)
            ->first();

        if ($existingVote) {
            if ($existingVote->vote_type === $voteType) {
                // Remove vote if clicking the same button
                $existingVote->delete();
                $this->updateVoteCounts($votable, $existingVote->vote_type, -1);
                $action = 'removed';
            } else {
                // Change vote type
                $oldVoteType = $existingVote->vote_type;
                $existingVote->update(['vote_type' => $voteType]);
                $this->updateVoteCounts($votable, $oldVoteType, -1);
                $this->updateVoteCounts($votable, $voteType, 1);
                $action = 'changed';
            }
        } else {
            // Create new vote
            ForumVote::create([
                'user_id' => $user->id,
                'votable_type' => $votableType,
                'votable_id' => $votableId,
                'vote_type' => $voteType,
            ]);
            $this->updateVoteCounts($votable, $voteType, 1);
            $action = 'added';
        }

        // Refresh the votable model to get updated counts
        $votable->refresh();

        return response()->json([
            'success' => true,
            'action' => $action,
            'upvotes' => $votable->upvotes,
            'downvotes' => $votable->downvotes,
            'score' => $votable->upvotes - $votable->downvotes,
            'user_vote' => $this->getUserVote($user->id, $votableType, $votableId),
        ]);
    }

    private function updateVoteCounts($votable, $voteType, $change)
    {
        if ($voteType === 'upvote') {
            $votable->increment('upvotes', $change);
        } else {
            $votable->increment('downvotes', $change);
        }
    }

    private function getUserVote($userId, $votableType, $votableId)
    {
        $vote = ForumVote::where('user_id', $userId)
            ->where('votable_type', $votableType)
            ->where('votable_id', $votableId)
            ->first();

        return $vote ? $vote->vote_type : null;
    }
} 