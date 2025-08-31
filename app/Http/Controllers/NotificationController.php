<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $notifications = $user->notifications()
            ->with('course')
            ->latest()
            ->paginate(15);
        
        $unreadCount = $user->unreadNotifications()->count();
        
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }
    
    public function show(Notification $notification)
    {
        $user = auth()->user();
        
        // Check if user owns this notification
        if ($notification->user_id !== $user->id) {
            return redirect()->route('notifications.index')
                ->with('error', 'You can only view your own notifications.');
        }
        
        // Mark as read if not already read
        if (!$notification->isRead()) {
            $notification->markAsRead();
        }
        
        return view('notifications.show', compact('notification'));
    }
    
    public function markAsRead(Notification $notification)
    {
        $user = auth()->user();
        
        // Check if user owns this notification
        if ($notification->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        $user = auth()->user();
        
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        return redirect()->route('notifications.index')
            ->with('success', 'All notifications marked as read!');
    }
} 