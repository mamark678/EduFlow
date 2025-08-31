<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to EduFlow</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --eduflow-blue: #183046;
            --eduflow-teal: #2ca39c;
            --eduflow-dark: #11202c;
            --eduflow-light: #f8fafc;
            --eduflow-gray: #e5e7eb;
            --eduflow-accent: #0e6e6e;
            --primary-blue: #3b82f6;
            --secondary-blue: #1e40af;
            --accent-blue: #0ea5e9;
            --accent-green: #10b981;
            --accent-purple: #8b5cf6;
            --warm-orange: #f59e0b;
            --coral: #ff6b6b;
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
            --gradient-primary: linear-gradient(135deg, #183046 0%, #1e293b 100%);
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
            background: var(--eduflow-blue);
            color: var(--eduflow-light);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navigation */
        .edu-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--eduflow-dark);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-xl);
            transition: all 0.3s ease;
        }

        .edu-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            pointer-events: none;
        }

        .edu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .edu-nav {
            width: 100%;
            background: var(--eduflow-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 3rem 1.5rem 2rem;
            box-shadow: 0 2px 8px #183046;
        }

        .edu-logo {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            text-decoration: none;
        }

        .edu-logo-icon {
            width: 44px;
            height: 44px;
            background: var(--eduflow-teal);
            color: var(--eduflow-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.7rem;
            box-shadow: 0 2px 8px hsla(176, 57.50%, 40.60%, 0.10);
        }

        .edu-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--eduflow-teal);
            letter-spacing: 1px;
        }

        .edu-nav-links {
            display: flex;
            gap: 2rem;
        }

        .edu-nav-link {
            color: var(--eduflow-light);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }

        .edu-nav-link:hover {
            background: var(--eduflow-teal);
            color: var(--eduflow-dark);
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: none;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                linear-gradient(rgba(30,41,59,0.7), rgba(30,41,59,0.7)),
                url('/images/library.png') center center/cover no-repeat;
            z-index: 0;
        }

        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 900px;
            padding: 2rem;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--border-color);
            border-radius: 2rem;
            color: var(--primary-blue);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-md);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            color: var(--eduflow-light);
            background: none;
            -webkit-text-fill-color: unset;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: #f3e9d2;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .edu-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 2rem;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .edu-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.5s ease;
        }

        .edu-btn:hover::before {
            left: 100%;
        }

        .edu-btn-primary {
            background: var(--eduflow-teal);
            color: var(--eduflow-light);
        }

        .edu-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .edu-btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
            backdrop-filter: blur(10px);
        }

        .edu-btn-secondary:hover {
            background: white;
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            opacity: 1;
            transform: translateY(0);
            animation: slideUpDelayed 0.8s ease-out;
        }

        @keyframes slideUpDelayed {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            60% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-item:nth-child(1) {
            animation-delay: 0.2s;
        }

        .stat-item:nth-child(2) {
            animation-delay: 0.4s;
        }

        .stat-item:nth-child(3) {
            animation-delay: 0.6s;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-primary);
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Features Section */
        .features-section {
            background: linear-gradient(180deg, var(--light-gray) 0%, var(--medium-gray) 100%);
            padding: 6rem 2rem;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-primary);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        /* This is the key fix - when .edu-fade-in is added, make cards visible */
        .feature-card.edu-fade-in {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: var(--eduflow-blue);
            padding: 3rem 0 2.5rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cta-container {
            background: var(--eduflow-dark);
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(44,163,156,0.10);
            padding: 2.5rem 2rem 2.5rem 2rem;
            max-width: 540px;
            text-align: center;
        }

        .cta-title {
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--eduflow-teal);
            margin-bottom: 1rem;
        }

        .cta-description {
            color: #dbeafe;
            font-size: 1.15rem;
            margin-bottom: 2rem;
        }

        .cta-btn {
            background: var(--eduflow-teal);
            color: var(--eduflow-light);
            border: none;
            border-radius: 12px;
            padding: 1rem 2.5rem;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(44,163,156,0.10);
            transition: background 0.2s, color 0.2s, transform 0.2s;
            text-decoration: none;
            gap: 0.7rem;
        }

        .cta-btn:hover {
            background: var(--eduflow-accent);
            color: #fff;
            transform: translateY(-2px) scale(1.04);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .edu-nav {
                flex-direction: column;
                gap: 1rem;
            }
            
            .edu-nav-links {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.125rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .edu-btn {
                width: 100%;
                max-width: 300px;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            text-align: center;
            cursor: pointer;
            position: relative;
        }
        .logo-container:hover .logo-icon {
            animation: logoHover 0.8s ease-in-out;
        }
        .logo-container:hover .logo-text {
            animation: textColorChange 0.8s ease-in-out;
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
        .logo-text {
            font-size: 21px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: 1px;
            opacity: 0;
            transform: translateY(10px);
            animation: fadeInText 1s ease-out 2s forwards, textPulse 4s ease-in-out 3s infinite;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .text-edu {
            color: #0891b2;
        }
        .text-flow {
            color: #1e293b;
        }
        .glow-ring {
            position: absolute;
            width: 70px;
            height: 70px;
            left: -5px;
            top: -5px;
            border: 1px solid rgba(8,145,178,0.3);
            border-radius: 50%;
            opacity: 0;
            transform: scale(0.5);
            animation: expandGlow 2s ease-out 2.5s forwards, glowPulse 4s ease-in-out 4s infinite;
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
            100% { opacity: 1; transform: translateX(0); }
        }
        @keyframes bounceInCap {
            0% { opacity: 0; transform: scale(0) rotate(45deg); }
            50% { opacity: 1; transform: scale(1.2) rotate(0deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }
        @keyframes tasselDrop {
            0% { opacity: 0; transform: translateY(-5px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInText {
            0% { opacity: 0; transform: translateY(10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes expandGlow {
            0% { opacity: 0; transform: scale(0.5); }
            50% { opacity: 1; transform: scale(1.1); }
            100% { opacity: 0.6; transform: scale(1); }
        }
        @keyframes floatParticle {
            0%, 100% { opacity: 0; transform: translateY(0); }
            50% { opacity: 1; transform: translateY(-7.5px); }
        }
        @keyframes loopAnimation {
            0%, 100% { transform: translateX(0) scale(1); }
            50% { transform: translateX(1px) scale(1.02); }
        }
        @keyframes capLoop {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.05) rotate(2deg); }
        }
        @keyframes tasselSwing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            75% { transform: rotate(-5deg); }
        }
        @keyframes textPulse {
            0%, 100% { transform: translateY(0) scale(1); color: #1e293b; }
            50% { transform: translateY(-1px) scale(1.02); color: #0891b2; }
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }
        @keyframes textColorChange {
            0%, 100% { color: #1e293b; }
            50% { color: #0891b2; }
        }
        .replay-btn {
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 12.5px;
            font-size: 7px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(8,145,178,0.3);
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeInBtn 0.5s ease-out 4s forwards;
        }
        .replay-btn:hover {
            transform: translateX(-50%) translateY(-1px);
            box-shadow: 0 3px 8px rgba(8,145,178,0.4);
        }
        .replay-btn:active {
            transform: translateX(-50%) translateY(0);
        }
        @keyframes fadeInBtn {
            0% { opacity: 0; transform: translateX(-50%) translateY(5px); }
            100% { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        .restart-animation .book {
            animation: none;
            opacity: 0;
            transform: translateX(-25px);
        }
        .restart-animation .graduation-cap {
            animation: none;
            opacity: 0;
            transform: scale(0) rotate(45deg);
        }
        .restart-animation .tassel {
            animation: none;
            opacity: 0;
        }
        .restart-animation .logo-text {
            animation: none;
            opacity: 0;
            transform: translateY(10px);
        }
        .restart-animation .glow-ring {
            animation: none;
            opacity: 0;
            transform: scale(0.5);
        }
        .restart-animation .particle {
            animation: none;
            opacity: 0;
        }
        @media (max-width: 768px) {
            .logo-icon {
                width: 50px;
                height: 50px;
            }
            .logo-text {
                font-size: 16px;
            }
            .book-stack {
                width: 40px;
                height: 32.5px;
                left: 5px;
                top: 9px;
            }
            .book {
                width: 40px;
                height: 6.5px;
            }
            .graduation-cap {
                width: 25px;
                height: 17.5px;
                left: 12.5px;
            }
        }

            </style>
    </head>
<body>
    <!-- Navigation Bar -->
    <div class="edu-header">
        <div class="edu-container">
            <nav class="edu-nav">
                <a href="{{ route('courses.index') }}" class="edu-logo" style="display: flex; align-items: center; gap: 0.7rem;">
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
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
                        <span style="font-size: 1.5rem; font-weight: 700; color: var(--eduflow-teal); letter-spacing: 1px;">EduFlow</span>
                    </span>
                </a>
                <div class="edu-nav-links">
                    <a href="{{ route('courses.index') }}" class="edu-nav-link">Courses</a>
                    <a href="{{ route('login') }}" class="edu-nav-link">Login</a>
                    <a href="{{ route('register') }}" class="edu-nav-link">Sign up</a>
                </div>
                </nav>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg-pattern"></div>
        <div class="hero-content">
            <div class="hero-badge">🚀 Modern E-Learning Platform</div>
            <h1 class="hero-title">Welcome to EduFlow</h1>
            <p class="hero-subtitle">
                Transform your learning journey with our cutting-edge e-learning platform. Create, manage, and join courses with powerful tools designed for modern education.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="edu-btn edu-btn-primary">
                    Get Started Free
                    <span>→</span>
                </a>
                <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-secondary">
                    Explore Courses
                    <span>📚</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="edu-container">
            <div class="section-header">
                <h2 class="section-title">Why Choose EduFlow?</h2>
                <p class="section-subtitle">
                    Experience the future of education with our comprehensive suite of learning tools and features.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📖</div>
                    <h3 class="feature-title">Course Management</h3>
                    <p class="feature-description">
                        Create and organize courses with intuitive tools. Upload materials, set schedules, and manage student enrollment effortlessly.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3 class="feature-title">Interactive Learning</h3>
                    <p class="feature-description">
                        Engage with peers and instructors through discussion forums, live chat, and collaborative projects.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Secure Platform</h3>
                    <p class="feature-description">
                        Your data is protected with enterprise-grade security measures and regular backups for peace of mind.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <h2 class="cta-title">Ready to Transform Your Learning?</h2>
            <p class="cta-description">
                Join thousands of students and educators who are already experiencing the future of education with EduFlow.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="cta-btn">
                    Start Your Journey
                    <span>🎓</span>
                </a>
            </div>
        </div>
    </section>

    <script>
        // Add smooth scrolling and navbar transparency effects

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('edu-fade-in');
                    // Optional: stop observing once animated
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all feature cards
        document.querySelectorAll('.feature-card').forEach(el => {
            observer.observe(el);
        });

        function replayAnimation() {
            const container = document.querySelector('.logo-container');
            container.classList.add('restart-animation');
            setTimeout(() => {
                container.classList.remove('restart-animation');
            }, 100);
        }
    </script>
    </body>
</html>