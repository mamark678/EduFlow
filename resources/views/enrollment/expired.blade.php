<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Expired - EduFlow</title>
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
            max-width: 500px;
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
        .icon {
            font-size: 64px;
            margin-bottom: 20px;
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
        .message {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .action-btn {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        .secondary-btn {
            background: none;
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        .secondary-btn:hover {
            background: var(--primary-blue);
            color: white;
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
        
        <div class="icon">⏰</div>
        <h1 class="title">Enrollment Link Expired</h1>
        <p class="subtitle">This enrollment link has expired or is no longer valid.</p>
        
        <div class="message">
            {{ $message }}
        </div>

        <div class="instructions">
            <h3>To enroll in the course:</h3>
            <ol>
                <li>Go back to the course page</li>
                <li>Click the "Enroll" button</li>
                <li>Check your email for a new verification link</li>
                <li>Complete the enrollment process</li>
            </ol>
        </div>

        <a href="{{ route('courses.index') }}" class="action-btn">Browse Courses</a>
        <a href="{{ route('dashboard') }}" class="secondary-btn">Go to Dashboard</a>
    </div>
</body>
</html> 