<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollment Approved</title>
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
            background-color: #10B981;
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
        .code-box {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            border: 2px dashed #10B981;
        }
        .enrollment-code {
            font-size: 24px;
            font-weight: bold;
            color: #10B981;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #10B981;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
        .warning {
            background-color: #FEF3C7;
            border: 1px solid #F59E0B;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Enrollment Approved!</h1>
    </div>
    
    <div class="content">
        <p>Congratulations! Your enrollment request for <strong>{{ $course->title }}</strong> has been approved by the instructor.</p>
        
        <p>To complete your enrollment, you need to use the enrollment code below:</p>
        
        <div class="code-box">
            <h3>Your Enrollment Code:</h3>
            <div class="enrollment-code">{{ $enrollmentCode }}</div>
        </div>
        
        <div class="warning">
            <strong>Important:</strong> This code is unique to you and this course. Please keep it secure and do not share it with others.
        </div>
        
        <p>To complete your enrollment:</p>
        <ol>
            <li>Go to the course page: <strong>{{ $course->title }}</strong></li>
            <li>Enter the enrollment code above</li>
            <li>Click "Complete Enrollment"</li>
        </ol>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ route('courses.show', $course) }}" class="button">Go to Course</a>
        </div>
        
        <p><strong>Course Details:</strong></p>
        <ul>
            <li><strong>Course:</strong> {{ $course->title }}</li>
            <li><strong>Instructor:</strong> {{ $course->instructor->name }}</li>
            <li><strong>Category:</strong> {{ $course->category }}</li>
            <li><strong>Difficulty:</strong> {{ $course->difficulty }}</li>
        </ul>
    </div>
    
    <div class="footer">
        <p>This is an automated message from EduFlow LMS.</p>
        <p>If you have any questions, please contact your instructor.</p>
    </div>
</body>
</html> 