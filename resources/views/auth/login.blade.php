<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduFlow - Login</title>
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
            overflow-x: hidden;
            position: relative;
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
            background: var(--gradient-primary);
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
        .sign-up-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .sign-up-link:hover {
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
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.2s ease;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #2ca39c 0%, #0891b2 100%);
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
        .auth-error {
            color: #f5576c;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .auth-error::before {
            content: '⚠️';
            font-size: 0.75rem;
        }
        @media (max-width: 900px) {
            .container { top: 40%; }
            .right-message { margin-top: 2vh; }
            .right-message h2 { font-size: 2.2rem; }
            .right-message p { font-size: 1.1rem; }
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
        }
        .wave-container {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            perspective: 1000px;
            z-index: 1;
        }
        .wave-grid {
            position: absolute;
            width: 150%;
            height: 150%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotateX(60deg) rotateY(0deg);
            transform-origin: center center;
        }
        .wave-line {
            position: absolute;
            width: 100%;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            transform-origin: center;
            animation: wave 3s ease-in-out infinite;
        }
        .wave-line:nth-child(odd) {
            background: rgba(255, 255, 255, 0.15);
        }
        .wave-line-vertical {
            position: absolute;
            width: 1px;
            height: 100%;
            background: rgba(255, 255, 255, 0.15);
            transform-origin: center;
            animation: wave-vertical 3s ease-in-out infinite;
        }
        .wave-line-vertical:nth-child(odd) {
            background: rgba(255, 255, 255, 0.1);
        }
        @keyframes wave {
            0%, 100% {
                transform: translateZ(0px) scaleY(1);
            }
            50% {
                transform: translateZ(20px) scaleY(1.1);
            }
        }
        @keyframes wave-vertical {
            0%, 100% {
                transform: translateZ(0px) scaleX(1);
            }
            50% {
                transform: translateZ(15px) scaleX(1.05);
            }
        }
        .wave-layer-1 {
            animation-delay: 0s;
            opacity: 0.6;
        }
        .wave-layer-2 {
            animation-delay: -1s;
            opacity: 0.4;
        }
        .wave-layer-3 {
            animation-delay: -2s;
            opacity: 0.2;
        }
    </style>
</head>
<body>
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
        <h1 class="welcome-title">Welcome Back! 👋</h1>
        <p class="welcome-subtitle">Sign in to your account to continue.</p>
        <p class="welcome-subtitle">Don't have an account? <a href="{{ route('register') }}" class="sign-up-link">Sign Up</a></p>
        <div class="form-container">
    <form method="POST" action="{{ route('login') }}">
        @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="john@example.com">
                    @error('email')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    @error('password')
                        <div class="auth-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" style="display: flex; align-items: center; justify-content: space-between;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.95rem; color: #64748b;">
                        <input type="checkbox" name="remember" id="remember" style="width: 18px; height: 18px; margin-right: 6px; accent-color: #667eea;">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="color: #3b82f6; text-decoration: none; font-size: 0.95rem;">Forgot Password?</a>
                    @endif
                </div>
                <button type="submit" class="submit-btn">Sign In</button>
            </form>
        </div>
    </div>
    <div class="right-panel">
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
        <div class="right-message">
            <h2>Welcome to EduFlow</h2>
            <p>Sign in to access your courses, assignments, and more!</p>
        </div>
    </div>
    <script>
        // Add some dynamic animation variation
        const waveLines = document.querySelectorAll('.wave-line, .wave-line-vertical');
        waveLines.forEach((line, index) => {
            const delay = (index * 0.05) + 's';
            const duration = (2.5 + Math.random() * 1) + 's';
            line.style.animationDelay = delay;
            line.style.animationDuration = duration;
        });
        // Optional: Add subtle mouse interaction
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth) * 2 - 1;
            const y = (e.clientY / window.innerHeight) * 2 - 1;
            const waveGrids = document.querySelectorAll('.wave-grid');
            waveGrids.forEach(grid => {
                grid.style.transform = `translate(-50%, -50%) rotateX(${60 + y * 3}deg) rotateY(${x * 3}deg)`;
            });
        });
    </script>
</body>
</html>
