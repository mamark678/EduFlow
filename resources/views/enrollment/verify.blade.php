<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Enrollment - EduFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #667eea;
            --secondary-blue: #764ba2;
            --accent-blue: #4facfe;
            --accent-green: #00f2fe;
            --accent-purple: #8b5cf6;
            --warm-orange: #fee140;
            --coral: #f5576c;
            --light-gray: #f8fafc;
            --medium-gray: #f1f5f9;
            --dark-gray: #0f172a;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --gradient-primary: linear-gradient(135deg, rgb(4, 8, 1) 0%,rgb(57, 102, 71) 100%);
            --gradient-accent: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-warm: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--gradient-primary);
            background-attachment: fixed;
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: var(--shadow-xl);
            text-align: center;
        }
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            color: var(--primary-blue);
        }
        .title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }
        .course-info {
            background: var(--gradient-primary);
            color: white;
            padding: 25px;
            border-radius: 15px;
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
        .enrollment-details {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        .enrollment-details h3 {
            margin-bottom: 15px;
            color: var(--text-primary);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid var(--border-light);
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 500;
            color: var(--text-secondary);
        }
        .detail-value {
            font-weight: 600;
            color: var(--text-primary);
        }
        .submit-btn {
            width: 100%;
            background: var(--gradient-success);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 20px 0;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        .cancel-btn {
            background: none;
            border: 2px solid var(--coral);
            color: var(--coral);
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .cancel-btn:hover {
            background: var(--coral);
            color: white;
        }
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
        .instructions {
            background: var(--light-gray);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        .instructions h3 {
            margin-bottom: 10px;
            color: var(--text-primary);
        }
        .instructions ol {
            margin-left: 20px;
            color: var(--text-secondary);
        }
        .instructions li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">EduFlow</div>
        
        <h1 class="title">Complete Your Enrollment</h1>
        <p class="subtitle">Please review your enrollment details and confirm to join the course.</p>
        
        <div class="course-info">
            <div class="course-name">{{ $verification->course->title }}</div>
            <div class="course-description">{{ $verification->course->description ?? 'Ready to start your learning journey!' }}</div>
        </div>

        <div class="enrollment-details">
            <h3>Enrollment Details</h3>
            <div class="detail-row">
                <span class="detail-label">Course:</span>
                <span class="detail-value">{{ $verification->course->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $verification->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Enrollment Date:</span>
                <span class="detail-value">{{ now()->format('F j, Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Access Duration:</span>
                <span class="detail-value">Lifetime</span>
            </div>
        </div>

        <div class="instructions">
            <h3>What happens next:</h3>
            <ol>
                <li>You'll be enrolled in the course immediately</li>
                <li>You'll have access to all course materials</li>
                <li>You can start learning right away</li>
                <li>You'll receive updates about new content</li>
            </ol>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('enrollment.verify', $verification->verification_token) }}?complete=1" class="submit-btn" style="display: inline-block; text-decoration: none;">
                Complete Enrollment
            </a>
        </div>

        <a href="{{ route('courses.show', $verification->course_id) }}" class="cancel-btn">Cancel Enrollment</a>

        <div class="warning">
            <strong>Important:</strong> This enrollment link will expire in 24 hours. If you don't complete your enrollment within this time, you'll need to request a new enrollment.
        </div>
    </div>
</body>
</html> 