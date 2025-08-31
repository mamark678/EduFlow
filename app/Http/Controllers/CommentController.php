<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to comment.');
        }

        // Check if user is student or instructor of this course
        if ($user->role === 'student') {
            if (!$module->course->enrollments()->where('user_id', $user->id)->where('status', 'approved')->whereNotNull('enrolled_at')->exists()) {
                return redirect()->back()->with('error', 'You must be enrolled in this course to comment.');
            }
        } elseif ($user->role === 'instructor') {
            if ($user->id !== $module->course->instructor_id) {
                return redirect()->back()->with('error', 'You can only comment on your own courses.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid user role.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = new Comment([
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);
        $comment->user()->associate($user);
        $comment->module()->associate($module);
        $comment->save();

        return redirect()->back()->with('success', 'Comment posted!');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to delete comments.');
        }

        // Check if user is the comment author or instructor of the course
        if ($user->role === 'student') {
            // Students can only delete their own comments
            if ($comment->user_id !== $user->id) {
                return redirect()->back()->with('error', 'You can only delete your own comments.');
            }
            
            // Check if student is enrolled in the course
            if (!$comment->module->course->enrollments()->where('user_id', $user->id)->where('status', 'approved')->whereNotNull('enrolled_at')->exists()) {
                return redirect()->back()->with('error', 'You must be enrolled in this course to delete comments.');
            }
        } elseif ($user->role === 'instructor') {
            // Instructors can delete any comment in their courses
            if ($user->id !== $comment->module->course->instructor_id) {
                return redirect()->back()->with('error', 'You can only delete comments in your own courses.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid user role.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
