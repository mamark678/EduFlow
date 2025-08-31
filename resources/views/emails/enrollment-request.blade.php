<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Enrollment Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }
        .student-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #4F46E5;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2563eb; /* vibrant blue */
            color: #fff !important; /* white text for contrast */
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: 600;
            font-size: 1rem;
            transition: background 0.2s;
        }
        .button:hover {
            background-color: #1d4ed8; /* darker blue on hover */
        }
        .button.reject {
            background-color: #DC2626;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Enrollment Request</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $course->instructor->name }},</p>
        
        <p>A student has requested to enroll in your course <strong>{{ $course->title }}</strong>.</p>
        
        <div class="student-info">
            <h3>Student Information:</h3>
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Request Date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>
        
        <p>Please review this enrollment request and take action:</p>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ route('enrollments.pending') }}" class="button">Review Enrollment Requests</a>
        </div>
        
        <p><strong>Note:</strong> If you approve the enrollment, the student will receive a unique enrollment code via email that they can use to complete their enrollment.</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message from EduFlow LMS.</p>
        <p>If you have any questions, please contact the system administrator.</p>
    </div>
</body>
</html> 