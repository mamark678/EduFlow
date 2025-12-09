<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\ModuleProgress;
use App\Models\Enrollment;
use Illuminate\Support\Carbon;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $user = auth()->user();
        
        // Check if user is the instructor of this course, an enrolled student, or an admin
        if ($user->id != $course->instructor_id && 
            !$course->enrollments()->where('user_id', $user->id)->where('status', 'approved')->whereNotNull('enrolled_at')->exists() &&
            $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // If user is instructor, show all modules. If student, show only published modules
        if ($user->id === $course->instructor_id) {
            $modules = $course->modules()->with('videos')->get();
        } else {
            $modules = $course->modules()->where('is_published', true)->with('videos')->get();
        }
        
        return view('modules.index', compact('course', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        if (auth()->user()->id != $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        return view('modules.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id != $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'support_file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar|max:51200',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'video_type' => 'nullable|in:file,url',
            'video_file' => 'required_if:video_type,file|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
            'video_url' => 'nullable|required_if:video_type,url|url',
            'video_source' => 'nullable|required_if:video_type,url|in:own_content,with_permission,fair_use,public_domain,creative_commons',
            'video_creator' => 'nullable|required_if:video_type,url|string|max:255',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'] ?? ($course->modules()->max('order') + 1),
            'is_published' => $validated['is_published'] ?? false,
            'video_type' => $validated['video_type'] ?? null,
        ];

        // Handle support file upload
        if ($request->hasFile('support_file')) {
            $file = $request->file('support_file');
            $data['support_file_path'] = $file->store('module_support', 'public');
            $data['support_file_name'] = $file->getClientOriginalName();
            $data['support_file_type'] = strtolower($file->getClientOriginalExtension());
            $data['support_file_size'] = $file->getSize();
        }

        // Handle video file upload
        if (($validated['video_type'] ?? null) === 'file' && $request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_path'] = $videoPath;
            $data['video_url'] = null;
        }

        // Handle external video URL
        if (($validated['video_type'] ?? null) === 'url') {
            $data['video_url'] = $validated['video_url'];
            $data['video_path'] = null;
            $data['video_source'] = $validated['video_source'] ?? null;
            $data['video_creator'] = $validated['video_creator'] ?? null;
        }

        $module = $course->modules()->create($data);

        return redirect()->route('courses.modules.index', $course)
            ->with('success', 'Module created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Module $module)
    {
        // Ensure the module belongs to the course
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        $user = auth()->user();
        // Check if user is the instructor of this course, an enrolled student, or an admin
        if ($user->id != $course->instructor_id && 
            !$course->enrollments()->where('user_id', $user->id)->where('status', 'approved')->whereNotNull('enrolled_at')->exists() &&
            $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $module->load('videos');
        // For instructors and admins, show all modules. For students, only published modules.
        if ($user->id === $course->instructor_id || $user->role === 'admin') {
            // Get all modules ordered by 'order' field
            $allModules = $course->modules()->orderBy('order', 'asc')->get();
        } else {
            // Get only published modules ordered by 'order' field
            $allModules = $course->modules()->where('is_published', true)->orderBy('order', 'asc')->get();
        }
        // Find the current module's position in the collection
        $currentIndex = $allModules->search(function ($item) use ($module) {
            return $item->id === $module->id;
        });
        // Get previous and next modules based on the collection index
        $previousModule = null;
        $nextModule = null;
        if ($currentIndex !== false) {
            // Get previous module (index - 1)
            if ($currentIndex > 0) {
                $previousModule = $allModules[$currentIndex - 1];
            }
            // Get next module (index + 1)
            if ($currentIndex < $allModules->count() - 1) {
                $nextModule = $allModules[$currentIndex + 1];
            }
        }
        // --- New logic for re-enrollment and previous progress ---
        $progress = \App\Models\ModuleProgress::where('user_id', $user->id)->where('module_id', $module->id)->first();
        return view('modules.show', compact('course', 'module', 'previousModule', 'nextModule', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Module $module)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id != $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        return view('modules.edit', compact('course', 'module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Module $module)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id != $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'support_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar|max:51200',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'video_type' => 'nullable|in:file,url',
            'video_file' => 'nullable|required_if:video_type,file|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
            'video_url' => 'nullable|required_if:video_type,url|url',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'is_published' => $validated['is_published'] ?? false,
            'video_type' => $validated['video_type'] ?? null,
        ];

        // Handle support file upload
        if ($request->hasFile('support_file')) {
            // Delete old file
            if ($module->support_file_path) {
                \Storage::disk('public')->delete($module->support_file_path);
            }
            $file = $request->file('support_file');
            $data['support_file_path'] = $file->store('module_support', 'public');
            $data['support_file_name'] = $file->getClientOriginalName();
            $data['support_file_type'] = strtolower($file->getClientOriginalExtension());
            $data['support_file_size'] = $file->getSize();
        }

        // Handle video file upload
        if (($validated['video_type'] ?? null) === 'file' && $request->hasFile('video_file')) {
            // Delete old video file if exists
            if ($module->video_path) {
                \Storage::disk('public')->delete($module->video_path);
            }
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $data['video_path'] = $videoPath;
            $data['video_url'] = null;
        }

        // Handle external video URL
        if (($validated['video_type'] ?? null) === 'url') {
            $data['video_url'] = $validated['video_url'];
            $data['video_path'] = null;
            $data['video_source'] = $validated['video_source'] ?? null;
            $data['video_creator'] = $validated['video_creator'] ?? null;
        }

        // If no video_type is selected, clear both fields
        if (empty($validated['video_type'])) {
            $data['video_path'] = null;
            $data['video_url'] = null;
        }

        $module->update($data);

        return redirect()->route('courses.modules.index', $course)
            ->with('success', 'Module updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Module $module)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id != $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $module->delete();

        return redirect()->route('courses.modules.index', $course)
            ->with('success', 'Module deleted successfully!');
    }

    /**
     * Reorder modules.
     */
    public function reorder(Request $request, Course $course)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id != $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'modules' => 'required|array',
            'modules.*.id' => 'required|exists:modules,id',
            'modules.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['modules'] as $moduleData) {
            Module::where('id', $moduleData['id'])
                ->where('course_id', $course->id)
                ->update(['order' => $moduleData['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display a student-friendly list of published modules for a course.
     */
    public function publicIndex(Course $course)
    {
        // Only allow access if the user is enrolled, is the instructor, or is an admin
        if (auth()->user()->id != $course->instructor_id &&
            !$course->enrollments()->where('user_id', auth()->id())->where('status', 'approved')->whereNotNull('enrolled_at')->exists() &&
            auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $modules = $course->modules()->where('is_published', true)->get();
        return view('modules.index', compact('course', 'modules'));
    }

    /**
     * Mark the module as finished for the current student.
     */
    public function finishModule(Course $course, Module $module)
    {
        $user = auth()->user();
        // Only students can finish modules
        if ($user->role === 'instructor') {
            abort(403, 'Instructors cannot finish modules.');
        }
        // Ensure the module belongs to the course
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        // Mark module as completed
        $progress = ModuleProgress::firstOrCreate([
            'user_id' => $user->id,
            'module_id' => $module->id,
        ]);
        if (!$progress->completed_at) {
            $progress->completed_at = Carbon::now();
            $progress->save();
        }
        // Check if all modules are completed for this course
        $moduleIds = $course->modules()->pluck('id')->toArray();
        $completedCount = ModuleProgress::where('user_id', $user->id)
            ->whereIn('module_id', $moduleIds)
            ->whereNotNull('completed_at')
            ->count();
        $totalModules = count($moduleIds);
        // If all modules completed, mark enrollment as completed
        if ($completedCount === $totalModules && $totalModules > 0) {
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
            if ($enrollment && !$enrollment->completed_at) {
                $enrollment->completed_at = Carbon::now();
                $enrollment->save();
            }
            return redirect()->route('courses.modules.show', [$course, $module])
                ->with('success', 'Good Job! You finished this subject');
        }
        return redirect()->route('courses.modules.show', [$course, $module])
            ->with('success', 'Module marked as finished!');
    }

    /**
     * Student chooses to proceed again: reset progress for this module (and course if needed)
     */
    public function proceedAgain(Course $course, Module $module)
    {
        $user = auth()->user();
        $progress = \App\Models\ModuleProgress::where('user_id', $user->id)->where('module_id', $module->id)->first();
        if ($progress) {
            $progress->completed_at = null;
            $progress->save();
        }
        // Optionally, reset course enrollment completion if needed
        $enrollment = $course->enrollments()->where('user_id', $user->id)->first();
        if ($enrollment && $enrollment->completed_at) {
            $enrollment->completed_at = null;
            $enrollment->save();
        }
        // Remove suppress flag if set
        session()->forget('suppress_finish_module_' . $module->id);
        return redirect()->route('courses.modules.show', [$course, $module]);
    }

    /**
     * Student chooses to keep previous progress: suppress finish button for this session
     */
    public function keepProgress(Course $course, Module $module)
    {
        session(['suppress_finish_module_' . $module->id => true]);
        return redirect()->route('courses.modules.show', [$course, $module]);
    }
}
