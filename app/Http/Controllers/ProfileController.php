<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle avatar upload - Convert to base64
        if ($request->hasFile('avatar')) {
            \Log::info('Avatar upload detected', [
                'original_name' => $request->file('avatar')->getClientOriginalName(),
                'size' => $request->file('avatar')->getSize(),
                'mime_type' => $request->file('avatar')->getMimeType()
            ]);
            
            $file = $request->file('avatar');
            
            // Get file contents and convert to base64
            $fileContents = file_get_contents($file->getRealPath());
            $base64 = base64_encode($fileContents);
            
            // Get mime type
            $mimeType = $file->getMimeType();
            
            // Create data URL
            $dataUrl = "data:{$mimeType};base64,{$base64}";
            
            \Log::info('Avatar converted to base64', [
                'original_size' => $file->getSize(),
                'base64_size' => strlen($base64),
                'mime_type' => $mimeType,
                'user_id' => $user->id
            ]);
            
            $user->avatar = $dataUrl;
        } else {
            \Log::info('No avatar file in request');
        }

        $user->save();
        
        \Log::info('User profile updated', [
            'user_id' => $user->id,
            'avatar' => $user->avatar,
            'name' => $user->name,
            'email' => $user->email
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // For base64 data URLs, we just need to clear the field
        // For file paths, delete the file (backward compatibility)
        if ($user->avatar && !str_starts_with($user->avatar, 'data:')) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }
        
        $user->avatar = null;
        $user->save();
        
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload the user's avatar only.
     */
    public function uploadAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = $request->user();
        $file = $request->file('avatar');
        
        try {
            // Get file contents and convert to base64
            $fileContents = file_get_contents($file->getRealPath());
            $base64 = base64_encode($fileContents);
            
            // Get mime type
            $mimeType = $file->getMimeType();
            
            // Create data URL
            $dataUrl = "data:{$mimeType};base64,{$base64}";
            
            $user->avatar = $dataUrl;
            $user->save();
            
            return redirect()->route('profile.edit')->with('status', 'profile-updated');
            
        } catch (\Exception $e) {
            \Log::error('Avatar upload failed: ' . $e->getMessage());
            return redirect()->route('profile.edit')->with('error', 'Failed to upload avatar. Please try again.');
        }
    }
}
