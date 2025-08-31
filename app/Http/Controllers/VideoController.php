<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, Module $module)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $videos = $module->videos()->ordered()->get();
        return view('videos.index', compact('course', 'module', 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course, Module $module)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        return view('videos.create', compact('course', 'module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course, Module $module)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:file,url',
            'video_file' => 'required_if:video_type,file|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
            'video_url' => 'required_if:video_type,url|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $videoData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_type' => $validated['video_type'],
            'order' => $validated['order'] ?? $module->videos()->max('order') + 1,
            'is_published' => $validated['is_published'] ?? false,
        ];

        // Handle video file upload
        if ($validated['video_type'] === 'file' && $request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $videoData['video_path'] = $videoPath;
        }

        // Handle external video URL
        if ($validated['video_type'] === 'url') {
            $videoData['video_url'] = $validated['video_url'];
        }
        
        // Handle thumbnail upload if provided
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $videoData['thumbnail_path'] = $thumbnailPath;
        }

        $video = $module->videos()->create($videoData);

        return redirect()->route('courses.modules.videos.index', [$course, $module])
            ->with('success', 'Video added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Module $module, Video $video)
    {
        // Check if user is the instructor of this course or an enrolled student
        if (auth()->user()->id !== $course->instructor_id && 
            !$course->enrollments()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Unauthorized');
        }

        return view('videos.show', compact('course', 'module', 'video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Module $module, Video $video)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        return view('videos.edit', compact('course', 'module', 'video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Module $module, Video $video)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:file,url',
            'video_file' => 'required_if:video_type,file|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
            'video_url' => 'required_if:video_type,url|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_type' => $validated['video_type'],
            'order' => $validated['order'],
            'is_published' => $validated['is_published'] ?? false,
        ];

        // Handle video file upload
        if ($validated['video_type'] === 'file' && $request->hasFile('video_file')) {
            // Delete old video file
            if ($video->video_path) {
                Storage::disk('public')->delete($video->video_path);
            }
            $updateData['video_path'] = $request->file('video_file')->store('videos', 'public');
            $updateData['video_url'] = null; // Clear URL if switching to file
        }

        // Handle external video URL
        if ($validated['video_type'] === 'url') {
            // Delete old video file if switching from file to URL
            if ($video->video_path) {
                Storage::disk('public')->delete($video->video_path);
            }
            $updateData['video_url'] = $validated['video_url'];
            $updateData['video_path'] = null; // Clear file path if switching to URL
        }

        // Handle new thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($video->thumbnail_path) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }
            $updateData['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video->update($updateData);

        return redirect()->route('courses.modules.videos.index', [$course, $module])
            ->with('success', 'Video updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Module $module, Video $video)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        // Delete video file
        if ($video->video_path) {
            Storage::disk('public')->delete($video->video_path);
        }

        // Delete thumbnail
        if ($video->thumbnail_path) {
            Storage::disk('public')->delete($video->thumbnail_path);
        }

        $video->delete();

        return redirect()->route('courses.modules.videos.index', [$course, $module])
            ->with('success', 'Video deleted successfully!');
    }

    /**
     * Stream video file.
     */
    public function stream(Course $course, Module $module, Video $video)
    {
        // Check if user is the instructor of this course or an enrolled student
        if (auth()->user()->id !== $course->instructor_id && 
            !$course->enrollments()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Unauthorized');
        }

        if (!$video->isFileUpload()) {
            abort(404, 'Video file not found');
        }

        $path = storage_path('app/public/' . $video->video_path);
        
        if (!file_exists($path)) {
            abort(404, 'Video file not found');
        }

        return response()->file($path);
    }
}
