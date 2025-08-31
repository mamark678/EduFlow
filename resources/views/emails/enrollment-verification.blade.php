<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Enrollment - EduFlow</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
        }
        .course-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
        }
        .course-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .course-description {
            font-size: 16px;
            opacity: 0.9;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .instructions {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .instructions h3 {
            margin-top: 0;
            color: #1e293b;
        }
        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 8px;
            color: #475569;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 14px;
        }
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .verification-link {
            word-break: break-all;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin: 20px 0;
            font-family: monospace;
            font-size: 14px;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">EduFlow</div>
            <h1 class="title">Complete Your Enrollment</h1>
            <p class="subtitle">Hi there! Please complete your enrollment for the course below.</p>
        </div>

        <div class="course-info">
            <div class="course-name">{{ $courseName }}</div>
            <div class="course-description">Ready to start your learning journey!</div>
        </div>

        <div class="instructions">
            <h3>To complete your enrollment:</h3>
            <ol>
                <li>Click the "Complete Enrollment" button below</li>
                <li>You'll be taken to a verification page</li>
                <li>Confirm your enrollment details</li>
                <li>Start learning immediately!</li>
            </ol>
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/enrollment/verify/' . $verificationToken) }}" class="cta-button">
                Complete Enrollment
            </a>
        </div>

        <div class="warning">
            <strong>Important:</strong> This enrollment link will expire in 24 hours. If you don't complete your enrollment within this time, you'll need to request a new enrollment.
        </div>

        <div class="footer">
            <p>If you didn't request enrollment for this course, please ignore this email.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html> 