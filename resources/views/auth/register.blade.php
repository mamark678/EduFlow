<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFlow - Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            height: 100vh;
            display: flex;
            overflow: hidden;
            background: linear-gradient(135deg, rgb(4, 8, 1) 0%, rgb(57, 102, 71) 100%);
            perspective: 1000px;
        }
        .left-panel {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 80px;
            max-width: 500px;
        }
        .right-panel {
            flex: 1;
            background: linear-gradient(135deg, rgb(4, 8, 1) 0%,rgb(57, 102, 71) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .container {
            position: absolute;
            top: 30%;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
            z-index: 1;
        }
        .item {
            position: absolute;
            background-color: transparent;
            width: calc(var(--i) * 5.5vmin);
            aspect-ratio: 1;
            border-radius: 50%;
            border: 1.5vmin solid rgb(0, 200, 255);
            transform-style: preserve-3d;
            transform: rotateX(70deg) translateZ(50px);
            animation: my-move 3s ease-in-out calc(var(--i) * 0.08s) infinite;
            box-shadow: 0px 0px 30px rgb(124, 124, 124),
                inset 0px 0px 30px rgb(124, 124, 124);
        }
        @keyframes my-move {
            0%,
            100% {
                transform: rotateX(70deg) translateZ(50px) translateY(0px);
                filter: hue-rotate(0deg);
            }
            50% {
                transform: rotateX(70deg) translateZ(50px) translateY(-50vmin);
                filter: hue-rotate(180deg);
            }
        }
        .right-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100%;
            z-index: 2;
            position: relative;
            text-align: center;
            padding: 2rem;
            margin-top: 6vh;
        }
        .right-message h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 12px rgba(0,0,0,0.12), 0 1px 0 #fff;
        }
        .right-message p {
            font-family: 'Inter', sans-serif;
            font-size: 1.25rem;
            color: #e0e7ff;
            max-width: 600px;
            line-height: 1.8;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 6px rgba(0,0,0,0.10);
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }
        .logo-icon {
            display: inline-block;
            position: relative;
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }
        .book-stack {
            position: absolute;
            width: 50px;
            height: 40px;
            left: 5px;
            top: 10px;
        }
        .book {
            position: absolute;
            width: 50px;
            height: 8px;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
            opacity: 0;
            transform: translateX(-25px);
        }
        .book-1 {
            background: linear-gradient(135deg, #22d3ee 0%, #0891b2 100%);
            top: 0;
            animation: slideInBook 0.8s ease-out 0.2s forwards, loopAnimation 5s ease-in-out 1s infinite;
        }
        .book-2 {
            background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
            top: 9px;
            animation: slideInBook 0.8s ease-out 0.4s forwards, loopAnimation 5s ease-in-out 1.2s infinite;
        }
        .book-3 {
            background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
            top: 18px;
            animation: slideInBook 0.8s ease-out 0.6s forwards, loopAnimation 5s ease-in-out 1.4s infinite;
        }
        .book-4 {
            background: linear-gradient(135deg, #34d399 0%, #059669 100%);
            top: 27px;
            animation: slideInBook 0.8s ease-out 0.8s forwards, loopAnimation 5s ease-in-out 1.6s infinite;
        }
        .book::before {
            content: '';
            position: absolute;
            right: 4px;
            top: 1px;
            width: 40px;
            height: 6px;
            background: rgba(255,255,255,0.9);
            border-radius: 2px;
            box-shadow: inset 0 0.5px 1px rgba(0,0,0,0.1);
        }
        .book::after {
            content: '';
            position: absolute;
            right: 6px;
            top: 2px;
            width: 1.5px;
            height: 4px;
            background: rgba(0,0,0,0.1);
            border-radius: 0.5px;
        }
        .graduation-cap {
            position: absolute;
            width: 30px;
            height: 20px;
            left: 15px;
            top: 0;
            opacity: 0;
            transform: scale(0) rotate(45deg);
            animation: bounceInCap 1s ease-out 1.2s forwards, capLoop 5s ease-in-out 2s infinite;
        }
        .cap-top {
            position: absolute;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            transform: rotate(45deg);
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
            top: -5px;
        }
        .cap-base {
            position: absolute;
            width: 15px;
            height: 6px;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            left: 7.5px;
            top: 10px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .tassel {
            position: absolute;
            width: 1px;
            height: 12.5px;
            background: linear-gradient(to bottom, #fbbf24, #f59e0b);
            right: 4px;
            top: 7.5px;
            border-radius: 0.5px;
            opacity: 0;
            animation: tasselDrop 0.6s ease-out 1.8s forwards, tasselSwing 3s ease-in-out 2.5s infinite;
        }
        .tassel::after {
            content: '';
            position: absolute;
            width: 3px;
            height: 3px;
            background: #fbbf24;
            bottom: -1.5px;
            left: -1px;
            border-radius: 50%;
            box-shadow: 0 0.5px 1.5px rgba(0,0,0,0.2);
        }
        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: #0891b2;
            border-radius: 50%;
            opacity: 0;
        }
        .particle-1 {
            left: 10px;
            top: 15px;
            animation: floatParticle 3s ease-in-out 3s infinite;
        }
        .particle-2 {
            right: 10px;
            top: 25px;
            animation: floatParticle 3s ease-in-out 3.5s infinite;
        }
        .particle-3 {
            left: 25px;
            bottom: 15px;
            animation: floatParticle 3s ease-in-out 4s infinite;
        }
        @keyframes slideInBook {
            0% { opacity: 0; transform: translateX(-25px); }
            60% { opacity: 1; transform: translateX(8px); }
            80% { opacity: 1; transform: translateX(-4px); }
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes loopAnimation {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(2px); }
        }
        @keyframes bounceInCap {
            0% { opacity: 0; transform: scale(0) rotate(45deg); }
            60% { opacity: 1; transform: scale(1.1) rotate(0deg); }
            80% { opacity: 1; transform: scale(0.95) rotate(-5deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }
        @keyframes capLoop {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.05) rotate(-3deg); }
        }
        @keyframes tasselDrop {
            0% { opacity: 0; height: 0; }
            100% { opacity: 1; height: 12.5px; }
        }
        @keyframes tasselSwing {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(18deg); }
        }
        @keyframes expandGlow {
            0% { opacity: 0; transform: scale(0.5); }
            100% { opacity: 1; transform: scale(1); }
        }
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 12px 2px #0891b2, 0 0 24px 8px #22d3ee44; }
            50% { box-shadow: 0 0 24px 8px #0891b2, 0 0 48px 16px #22d3ee33; }
        }
        @keyframes floatParticle {
            0%, 100% { opacity: 0; transform: translateY(0); }
            10% { opacity: 1; }
            50% { opacity: 1; transform: translateY(-8px); }
            90% { opacity: 1; }
        }
        .logo-text {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }
        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .welcome-subtitle {
            color: #6b7280;
            margin-bottom: 8px;
            font-size: 15px;
        }
        .sign-in-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .sign-in-link:hover {
            text-decoration: underline;
        }
        .form-container {
            margin-top: 32px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .form-input, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.2s ease;
            background: white;
        }
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #3b82f6;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .password-strength {
            margin-top: 6px;
            height: 3px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .password-strength.show {
            opacity: 1;
        }
        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        .password-strength-bar.weak {
            width: 25%;
            background: #ef4444;
        }
        .password-strength-bar.fair {
            width: 50%;
            background: #f59e0b;
        }
        .password-strength-bar.good {
            width: 75%;
            background: #3b82f6;
        }
        .password-strength-bar.strong {
            width: 100%;
            background: #10b981;
        }
        .submit-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(90deg, #2ca39c 0%, #0891b2 100%); /* EduFlow teal/blue */
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 8px;
    box-shadow: 0 2px 8px rgba(44,163,156,0.10);
    text-shadow: 0 1px 2px rgba(0,0,0,0.08);
}
.submit-btn:hover {
    background: linear-gradient(90deg, #0891b2 0%, #2ca39c 100%);
    transform: translateY(-1px) scale(1.02);
}
        .divider {
            text-align: center;
            margin: 24px 0;
            color: #9ca3af;
            font-size: 14px;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
            z-index: 1;
        }
        .divider span {
            background: white;
            padding: 0 16px;
            position: relative;
            z-index: 2;
        }
        .social-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .social-btn {
            width: 48px;
            height: 48px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }
        .social-btn:hover {
            border-color: #3b82f6;
            transform: translateY(-1px);
        }
        .feature-list {
            list-style: none;
            z-index: 10;
            position: relative;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            font-size: 18px;
            font-weight: 500;
        }
        .feature-item::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            margin-right: 16px;
            font-size: 14px;
        }
        .terms-text {
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            margin-top: 16px;
            line-height: 1.5;
        }
        .terms-link {
            color: #3b82f6;
            text-decoration: none;
        }
        .terms-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .left-panel {
                max-width: none;
                padding: 40px 24px;
            }
            .right-panel {
                display: none;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 900px) {
            .container { top: 40%; }
            .right-message { margin-top: 2vh; }
            .right-message h2 { font-size: 2.2rem; }
            .right-message p { font-size: 1.1rem; }
        }
        .wave-container {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            z-index: 1;
        }
        .wave-grid {
            position: absolute;
            width: 200%;
            height: 200%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotateX(60deg) rotateY(0deg);
            transform-origin: center center;
        }
        .wave-line {
            position: absolute;
            width: 100%;
            height: 2px;
            background: rgba(255, 255, 255, 0.3);
            transform-origin: center;
            animation: wave 3s ease-in-out infinite;
        }
        .wave-line:nth-child(odd) {
            background: rgba(255, 255, 255, 0.2);
        }
        .wave-line-vertical {
            position: absolute;
            width: 2px;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transform-origin: center;
            animation: wave-vertical 3s ease-in-out infinite;
        }
        .wave-line-vertical:nth-child(odd) {
            background: rgba(255, 255, 255, 0.15);
        }
        @keyframes wave {
            0%, 100% { transform: translateZ(0px) scaleY(1); }
            50% { transform: translateZ(30px) scaleY(1.1); }
        }
        @keyframes wave-vertical {
            0%, 100% { transform: translateZ(0px) scaleX(1); }
            50% { transform: translateZ(25px) scaleX(1.05); }
        }
        .wave-layer-1 { animation-delay: 0s; opacity: 0.7; }
        .wave-layer-2 { animation-delay: -1s; opacity: 0.5; }
        .wave-layer-3 { animation-delay: -2s; opacity: 0.3; }
        .left-panel, .right-panel, .form-container, .logo, .welcome-title, .welcome-subtitle {
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="wave-container">
        <div class="wave-grid wave-layer-1">
            <div class="wave-line" style="top: 10%;"></div>
            <div class="wave-line" style="top: 20%;"></div>
            <div class="wave-line" style="top: 30%;"></div>
            <div class="wave-line" style="top: 40%;"></div>
            <div class="wave-line" style="top: 50%;"></div>
            <div class="wave-line" style="top: 60%;"></div>
            <div class="wave-line" style="top: 70%;"></div>
            <div class="wave-line" style="top: 80%;"></div>
            <div class="wave-line" style="top: 90%;"></div>
            <div class="wave-line-vertical" style="left: 10%;"></div>
            <div class="wave-line-vertical" style="left: 20%;"></div>
            <div class="wave-line-vertical" style="left: 30%;"></div>
            <div class="wave-line-vertical" style="left: 40%;"></div>
            <div class="wave-line-vertical" style="left: 50%;"></div>
            <div class="wave-line-vertical" style="left: 60%;"></div>
            <div class="wave-line-vertical" style="left: 70%;"></div>
            <div class="wave-line-vertical" style="left: 80%;"></div>
            <div class="wave-line-vertical" style="left: 90%;"></div>
        </div>
        <div class="wave-grid wave-layer-2">
            <div class="wave-line" style="top: 15%;"></div>
            <div class="wave-line" style="top: 25%;"></div>
            <div class="wave-line" style="top: 35%;"></div>
            <div class="wave-line" style="top: 45%;"></div>
            <div class="wave-line" style="top: 55%;"></div>
            <div class="wave-line" style="top: 65%;"></div>
            <div class="wave-line" style="top: 75%;"></div>
            <div class="wave-line" style="top: 85%;"></div>
            <div class="wave-line-vertical" style="left: 15%;"></div>
            <div class="wave-line-vertical" style="left: 25%;"></div>
            <div class="wave-line-vertical" style="left: 35%;"></div>
            <div class="wave-line-vertical" style="left: 45%;"></div>
            <div class="wave-line-vertical" style="left: 55%;"></div>
            <div class="wave-line-vertical" style="left: 65%;"></div>
            <div class="wave-line-vertical" style="left: 75%;"></div>
            <div class="wave-line-vertical" style="left: 85%;"></div>
        </div>
    </div>
    <div class="left-panel">
        <div class="logo">
            <div class="logo-icon">
                <div class="glow-ring"></div>
                <div class="book-stack">
                    <div class="book book-1"></div>
                    <div class="book book-2"></div>
                    <div class="book book-3"></div>
                    <div class="book book-4"></div>
                </div>
                <div class="graduation-cap">
                    <div class="cap-top"></div>
                    <div class="cap-base"></div>
                    <div class="tassel"></div>
                </div>
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
            </div>
            <span class="logo-text">EduFlow</span>
        </div>
        <h1 class="welcome-title">Hello There! 👋</h1>
        <p class="welcome-subtitle">Enter your info to Sign Up!</p>
        <p class="welcome-subtitle">Already have an account? <a href="{{ route('login') }}" class="sign-in-link">Sign In</a></p>
        <div class="form-container">
    <form method="POST" action="{{ route('register') }}">
        @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
                        @error('name')
                            <div style="color:#ef4444; font-size:13px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="john@example.com">
                        @error('email')
                            <div style="color:#ef4444; font-size:13px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" onkeyup="checkPasswordStrength(this.value)">
                        <div class="password-strength" id="passwordStrength">
                            <div class="password-strength-bar" id="passwordStrengthBar"></div>
                        </div>
                        @error('password')
                            <div style="color:#ef4444; font-size:13px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                        @error('password_confirmation')
                            <div style="color:#ef4444; font-size:13px; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">I want to join as</label>
                    <select id="role" name="role" class="form-input form-select" required>
                        <option value="">Select your role...</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>📚 Student - I want to learn</option>
                        <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>👨‍🏫 Instructor - I want to teach</option>
                    </select>
                    @error('role')
                        <div style="color:#ef4444; font-size:13px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="submit-btn">Sign Up</button>
                <div class="terms-text">
                    By creating an account, you agree to our
                    <a href="#" class="terms-link">Terms of Service</a> and
                    <a href="#" class="terms-link">Privacy Policy</a>
                </div>
            </form>
        
        </div>
        </div>
    <div class="right-panel">
        <div class="container">
            <div class="item" style="--i:1"></div>
            <div class="item" style="--i:2"></div>
            <div class="item" style="--i:3"></div>
            <div class="item" style="--i:4"></div>
            <div class="item" style="--i:5"></div>
            <div class="item" style="--i:6"></div>
        </div>
        <div class="right-message">
            <h2>Thank you for using EduFlow</h2>
            <p>Empowering your learning journey with a modern, beautiful, and easy-to-use e-learning platform.</p>
        </div>
        </div>
    <script>
        function checkPasswordStrength(password) {
            const strengthIndicator = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('passwordStrengthBar');
            if (!strengthIndicator || !strengthBar) return;
            if (password.length === 0) {
                strengthIndicator.classList.remove('show');
                return;
            }
            strengthIndicator.classList.add('show');
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            strengthBar.className = 'password-strength-bar';
            if (strength <= 2) {
                strengthBar.classList.add('weak');
            } else if (strength === 3) {
                strengthBar.classList.add('fair');
            } else if (strength === 4) {
                strengthBar.classList.add('good');
            } else {
                strengthBar.classList.add('strong');
            }
        }
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Add social login functionality here
                console.log('Social login clicked');
            });
        });
        // Add some dynamic animation variation for the wave lines
        const waveLines = document.querySelectorAll('.wave-line, .wave-line-vertical');
        waveLines.forEach((line, index) => {
            const delay = (index * 0.1) + 's';
            const duration = (2 + Math.random() * 2) + 's';
            line.style.animationDelay = delay;
            line.style.animationDuration = duration;
        });
        // Optional: Add mouse interaction
        // (If you want to keep this, add the code from Claude's example)
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth) * 2 - 1;
            const y = (e.clientY / window.innerHeight) * 2 - 1;
            const waveGrids = document.querySelectorAll('.wave-grid');
            waveGrids.forEach(grid => {
                grid.style.transform = `translate(-50%, -50%) rotateX(${60 + y * 5}deg) rotateY(${x * 5}deg)`;
            });
        });
    </script>
</body>
</html>
