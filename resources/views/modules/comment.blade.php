@php
    $isInstructor = $comment->user->role === 'instructor';
@endphp
<div style="background: {{ $isInstructor ? '#f0f9ff' : '#f3f4f6' }}; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; border-left: 4px solid {{ $isInstructor ? '#0ea5e9' : '#2563eb' }}; margin-left: {{ $depth * 24 }}px;">
    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
        <span style="font-weight: 600; color: {{ $isInstructor ? '#0c4a6e' : '#2563eb' }};">{{ $comment->user->name }}</span>
        <span style="color: #6b7280; font-size: 0.9rem;">&middot; {{ $comment->created_at->diffForHumans() }}</span>
        @if($isInstructor)
            <span style="color: #0c4a6e; font-size: 0.8rem; font-weight: 500;">(Instructor)</span>
        @endif
    </div>
    <div style="color: #374151; font-size: 1rem; white-space: pre-line;">{{ $comment->content }}</div>
    {{-- Action Buttons --}}
    @if(auth()->user())
        <div style="margin-top: 0.5rem; display: flex; gap: 0.5rem;">
            <button onclick="toggleReplyForm({{ $comment->id }})" class="edu-btn" style="background: #10b981; color: white; padding: 0.25rem 0.75rem; font-size: 0.8rem; border: none; border-radius: 4px; cursor: pointer;">
                Reply
            </button>
            @if(auth()->user()->id === $comment->user_id || (auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id))
                <form method="POST" action="{{ route('comments.destroy', $comment) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="openDeleteModal(this.form)" class="edu-btn" style="background: #ef4444; color: white; padding: 0.25rem 0.75rem; font-size: 0.8rem; border: none; border-radius: 4px; cursor: pointer;">
                        Delete
                    </button>
                </form>
            @endif
        </div>
        {{-- Reply Form (Hidden by default) --}}
        <div id="replyForm{{ $comment->id }}" style="display: none; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <form method="POST" action="{{ route('courses.modules.comments.store', [$course->id, $module->id]) }}">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content" rows="2" placeholder="Write your reply..." required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 0.9rem; margin-bottom: 0.5rem;"></textarea>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="edu-btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; font-size: 0.9rem; border: none; border-radius: 4px; cursor: pointer;">
                        Post Reply
                    </button>
                    <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="edu-btn" style="background: #6b7280; color: white; padding: 0.5rem 1rem; font-size: 0.9rem; border: none; border-radius: 4px; cursor: pointer;">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif
    {{-- Replies (recursive) --}}
    @if($comment->replies->count() > 0)
        <div style="margin-top: 1rem;">
            @foreach($comment->replies as $reply)
                @include('modules.comment', ['comment' => $reply, 'module' => $module, 'course' => $course, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div> 