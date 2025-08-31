<div style="font-family: Arial, sans-serif;">
    <h2>{{ $subjectLine ?? 'Message from Admin' }}</h2>
    <p>{{ $bodyMessage }}</p>
    @if($course)
        <hr>
        <p><strong>Related Course:</strong> {{ $course->title }}</p>
    @endif
    <br>
    <p>Best regards,<br>EduFlow Admin Team</p>
</div> 