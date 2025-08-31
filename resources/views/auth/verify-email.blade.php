<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - EduFlow</title>
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
        .email-display {
            background: var(--light-gray);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: 500;
            color: var(--text-primary);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 8px;
            text-align: left;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            text-align: center;
            letter-spacing: 4px;
            font-weight: 600;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .submit-btn {
            width: 100%;
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        .resend-btn {
            background: none;
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .resend-btn:hover {
            background: var(--primary-blue);
            color: white;
        }
        .auth-error {
            color: var(--coral);
            font-size: 14px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .auth-error::before {
            content: '⚠️';
            font-size: 12px;
        }
        .status {
            background: var(--accent-green);
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
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
        .warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">EduFlow</div>
        
        <h1 class="title">Verify Your Email</h1>
        <p class="subtitle">Hi {{ $userName }}, please verify your email address to complete your registration.</p>
        
        <div class="email-display">
            {{ $email }}
        </div>

        @if (session('status'))
            <div class="status">
                {{ session('status') }}
            </div>
        @endif

        <div class="instructions">
            <h3>How to verify your email:</h3>
            <ol>
                <li>Check your email inbox for a verification code</li>
                <li>Copy the 6-digit verification code</li>
                <li>Enter the code in the field below</li>
                <li>Click "Verify Email" to complete registration</li>
            </ol>
        </div>

        <form method="POST" action="{{ route('email.verification.verify') }}">
            @csrf
            <div class="form-group">
                <label for="verification_code" class="form-label">Verification Code</label>
                <input 
                    id="verification_code" 
                    class="form-input" 
                    type="text" 
                    name="verification_code" 
                    required 
                    autofocus 
                    maxlength="6"
                    placeholder="000000"
                    pattern="[A-Z0-9]{6}"
                    title="Please enter a 6-character verification code"
                >
                @error('verification_code')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="submit-btn">Verify Email</button>
        </form>

        <form method="POST" action="{{ route('email.verification.resend') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="resend-btn">Resend Verification Code</button>
        </form>

        <div class="warning">
            <strong>Important:</strong> This verification code will expire in 10 minutes. If you don't verify your email within this time, you'll need to request a new code.
        </div>
    </div>

    <script>
        // Auto-format verification code input
        document.getElementById('verification_code').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');
            e.target.value = value;
        });
    </script>
</body>
</html>
