<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
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

        $documents = $module->documents()->ordered()->get();
        return view('documents.index', compact('course', 'module', 'documents'));
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

        return view('documents.create', compact('course', 'module'));
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
            'document_file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar|max:51200', // 50MB max
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        // Handle file upload
        $file = $request->file('document_file');
        $filePath = $file->store('documents', 'public');
        $fileType = strtolower($file->getClientOriginalExtension());
        $fileSize = $file->getSize();

        // If no order is specified, set it to the next available order
        if (!isset($validated['order'])) {
            $validated['order'] = $module->documents()->max('order') + 1;
        }

        $document = $module->documents()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'original_filename' => $file->getClientOriginalName(),
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'order' => $validated['order'],
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return redirect()->route('courses.modules.documents.index', [$course, $module])
            ->with('success', 'Document uploaded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Module $module, Document $document)
    {
        // Check if user is the instructor of this course or an enrolled student
        if (auth()->user()->id !== $course->instructor_id && 
            !$course->enrollments()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Unauthorized');
        }

        return view('documents.show', compact('course', 'module', 'document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Module $module, Document $document)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        return view('documents.edit', compact('course', 'module', 'document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Module $module, Document $document)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar|max:51200',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'],
            'is_published' => $validated['is_published'] ?? false,
        ];

        // Handle new file upload
        if ($request->hasFile('document_file')) {
            // Delete old file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('document_file');
            $filePath = $file->store('documents', 'public');
            $fileType = strtolower($file->getClientOriginalExtension());
            $fileSize = $file->getSize();

            $updateData['file_path'] = $filePath;
            $updateData['original_filename'] = $file->getClientOriginalName();
            $updateData['file_type'] = $fileType;
            $updateData['file_size'] = $fileSize;
        }

        $document->update($updateData);

        return redirect()->route('courses.modules.documents.index', [$course, $module])
            ->with('success', 'Document updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Module $module, Document $document)
    {
        // Check if user is the instructor of this course
        if (auth()->user()->id !== $course->instructor_id) {
            abort(403, 'Unauthorized');
        }

        // Delete file
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('courses.modules.documents.index', [$course, $module])
            ->with('success', 'Document deleted successfully!');
    }

    /**
     * Download document file.
     */
    public function download(Course $course, Module $module, Document $document)
    {
        // Check if user is the instructor of this course or an enrolled student
        if (auth()->user()->id !== $course->instructor_id && 
            !$course->enrollments()->where('user_id', auth()->id())->exists()) {
            abort(403, 'Unauthorized');
        }

        $path = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($path)) {
            abort(404, 'Document file not found');
        }

        return response()->download($path, $document->original_filename);
    }
}
