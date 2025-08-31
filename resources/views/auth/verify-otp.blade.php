<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification - EduFlow</title>
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
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            background: var(--gradient-success);
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
        .security-note {
            background: #dbeafe;
            border: 1px solid #3b82f6;
            color: #1e40af;
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
        
        <h1 class="title">Login Verification</h1>
        <p class="subtitle">Hi {{ $userName }}, please enter the verification code to complete your login.</p>
        
        <div class="email-display">
            {{ $email }}
        </div>

        @if (session('status'))
            <div class="status">
                {{ session('status') }}
            </div>
        @endif

        <div class="instructions">
            <h3>How to complete your login:</h3>
            <ol>
                <li>Check your email inbox for a verification code</li>
                <li>Copy the 6-digit verification code</li>
                <li>Enter the code in the field below</li>
                <li>Click "Verify & Login" to access your account</li>
            </ol>
        </div>

        <!-- OTP Timer -->
        <div id="otp-timer" style="font-size: 18px; font-weight: 600; color: var(--primary-blue); margin-bottom: 20px;">
            Time remaining: <span id="timer-value">10:00</span>
        </div>

        <form id="otp-form" method="POST" action="{{ route('otp.verification.verify') }}">
            @csrf
            <div class="form-group">
                <label for="otp_code" class="form-label">Verification Code</label>
                <input 
                    id="otp_code" 
                    class="form-input" 
                    type="text" 
                    name="otp_code" 
                    required 
                    autofocus 
                    maxlength="6"
                    placeholder="000000"
                    pattern="[A-Z0-9]{6}"
                    title="Please enter a 6-character verification code"
                >
                @error('otp_code')
                    <div class="auth-error">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="submit-btn">Verify & Login</button>
        </form>

        <form method="POST" action="{{ route('otp.verification.resend') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="resend-btn">Resend Verification Code</button>
        </form>

        <div class="security-note">
            <strong>Security Notice:</strong> This verification code was requested for your EduFlow account login. If you didn't attempt to log in, please contact support immediately.
        </div>
    </div>

    <script>
        // Auto-format OTP code input
        document.getElementById('otp_code').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/[^A-Z0-9]/g, '');
            e.target.value = value;
        });

        // Real-time 10-minute countdown timer
        let timerSeconds = 600; // 10 minutes
        const timerValue = document.getElementById('timer-value');
        const otpForm = document.getElementById('otp-form');
        const submitBtn = otpForm.querySelector('.submit-btn');
        const resendBtn = document.querySelector('.resend-btn');
        let timerInterval = setInterval(function() {
            let minutes = Math.floor(timerSeconds / 60);
            let seconds = timerSeconds % 60;
            timerValue.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            if (timerSeconds <= 0) {
                clearInterval(timerInterval);
                timerValue.textContent = '00:00';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Code Expired';
                document.getElementById('otp_code').disabled = true;
                // Optionally, show a message
                let expiredMsg = document.createElement('div');
                expiredMsg.className = 'auth-error';
                expiredMsg.textContent = 'The verification code has expired. Please request a new code.';
                otpForm.parentNode.insertBefore(expiredMsg, otpForm.nextSibling);
                if (resendBtn) {
                    resendBtn.focus();
                }
            }
            timerSeconds--;
        }, 1000);
    </script>
</body>
</html> 