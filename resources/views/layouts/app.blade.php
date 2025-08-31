<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EduFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Trix Editor CSS -->
        <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

        <!-- EduFlow Aligned App Layout CSS -->
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
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, var(--eduflow-light) 0%, var(--eduflow-gray) 100%);
                color: var(--text-primary);
                line-height: 1.6;
                margin: 0;
                padding: 0;
                min-height: 100vh;
            }

            .edu-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 1rem;
            }

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

            .edu-nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem 2rem;
                position: relative;
                z-index: 10;
            }

            .edu-logo {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                text-decoration: none;
                font-family: 'Poppins', sans-serif;
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--eduflow-teal);
                letter-spacing: 1px;
                transition: all 0.3s ease;
            }

            .edu-logo:hover {
                transform: translateY(-2px);
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

            .edu-nav-links {
                display: flex;
                gap: 2rem;
                align-items: center;
            }

            .edu-nav-link {
                color: var(--eduflow-light);
                background: transparent;
                text-decoration: none;
                font-weight: 600;
                font-size: 1.1rem;
                padding: 0.5rem 1.2rem;
                border-radius: 8px;
                transition: all 0.3s ease;
                position: relative;
                backdrop-filter: blur(10px);
            }

            .edu-nav-link:hover {
                background: var(--eduflow-teal);
                color: var(--eduflow-dark);
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }
            .edu-nav-link[aria-expanded="true"],
            .edu-nav-link.active {
                background: var(--eduflow-teal);
                color: var(--eduflow-dark);
            }

            .edu-dropdown {
                position: relative;
            }

            .edu-dropdown-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background: white;
                border-radius: 16px;
                box-shadow: var(--shadow-xl);
                padding: 0.5rem;
                min-width: 200px;
                backdrop-filter: blur(20px);
                border: 1px solid var(--border-color);
                z-index: 1000;
                animation: slideDown 0.3s ease-out;
            }

            .edu-dropdown-item {
                display: block;
                padding: 0.75rem 1rem;
                color: var(--text-primary);
                text-decoration: none;
                border-radius: 8px;
                transition: all 0.3s ease;
                font-size: 0.9rem;
            }

            .edu-dropdown-item:hover {
                background: var(--eduflow-light);
                color: var(--eduflow-teal);
            }

            /* Notification Styles */
            .notification-btn {
                position: relative;
                padding: 8px 12px;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .notification-btn:hover {
                background: rgba(255, 255, 255, 0.1);
                transform: scale(1.05);
            }

            .notification-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: linear-gradient(135deg, #ff4757, #ff3742);
                color: white;
                font-size: 10px;
                font-weight: bold;
                padding: 2px 6px;
                border-radius: 10px;
                min-width: 18px;
                text-align: center;
                box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }

            .notification-dropdown {
                min-width: 350px;
                max-width: 400px;
                max-height: 500px;
                overflow-y: auto;
            }

            .notification-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 16px 20px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .notification-header h3 {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
            }

            .mark-all-read-btn {
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .mark-all-read-btn:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-1px);
            }

            .notification-list {
                max-height: 350px;
                overflow-y: auto;
            }

            .notification-item {
                display: flex;
                align-items: flex-start;
                padding: 16px 20px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
            }

            .notification-item:hover {
                background: rgba(102, 126, 234, 0.05);
            }

            .notification-item.unread {
                background: rgba(102, 126, 234, 0.08);
            }

            .notification-item.unread:hover {
                background: rgba(102, 126, 234, 0.12);
            }

            .notification-content {
                flex: 1;
                min-width: 0;
            }

            .notification-title {
                font-weight: 600;
                font-size: 14px;
                color: #2d3748;
                margin-bottom: 4px;
                line-height: 1.3;
            }

            .notification-message {
                font-size: 13px;
                color: #718096;
                margin-bottom: 6px;
                line-height: 1.4;
            }

            .notification-course {
                font-size: 12px;
                color: #667eea;
                font-weight: 500;
                margin-bottom: 4px;
            }

            .notification-time {
                font-size: 11px;
                color: #a0aec0;
            }

            .unread-indicator {
                width: 8px;
                height: 8px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                border-radius: 50%;
                margin-left: 12px;
                margin-top: 6px;
                flex-shrink: 0;
                animation: pulse 2s infinite;
            }

            .no-notifications {
                text-align: center;
                padding: 40px 20px;
                color: #a0aec0;
            }

            .no-notifications-icon {
                font-size: 48px;
                margin-bottom: 12px;
                opacity: 0.5;
            }

            .no-notifications p {
                margin: 0;
                font-size: 14px;
            }

            .notification-footer {
                padding: 12px 20px;
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                text-align: center;
                background: rgba(102, 126, 234, 0.02);
            }

            .view-all-notifications {
                color: #667eea;
                text-decoration: none;
                font-size: 13px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .view-all-notifications:hover {
                color: #5a67d8;
                text-decoration: underline;
            }

            /* Scrollbar styling for notification list */
            .notification-list::-webkit-scrollbar {
                width: 6px;
            }

            .notification-list::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.05);
                border-radius: 3px;
            }

            .notification-list::-webkit-scrollbar-thumb {
                background: rgba(102, 126, 234, 0.3);
                border-radius: 3px;
            }

            .notification-list::-webkit-scrollbar-thumb:hover {
                background: rgba(102, 126, 234, 0.5);
            }

            .edu-main {
                min-height: calc(100vh - 80px);
                padding: 6rem 0 2rem 0;
                margin-top: 80px;
            }

            .edu-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: 20px;
                box-shadow: var(--shadow-lg);
                padding: 2.5rem;
                margin-bottom: 2rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
            }

            .edu-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: var(--gradient-primary);
            }

            .edu-card:hover {
                box-shadow: var(--shadow-xl);
                transform: translateY(-4px);
            }

            .edu-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.875rem 1.75rem;
                border-radius: 16px;
                font-weight: 600;
                text-decoration: none;
                border: none;
                cursor: pointer;
                transition: all 0.4s ease;
                font-size: 0.9rem;
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
                background: var(--eduflow-accent);
                transform: translateY(-3px);
                box-shadow: var(--shadow-xl);
            }

            .edu-btn-secondary {
                background: rgba(255, 255, 255, 0.9);
                color: var(--text-primary);
                border: 2px solid var(--border-color);
            }

            .edu-btn-secondary:hover {
                background: white;
                border-color: var(--eduflow-teal);
                color: var(--eduflow-teal);
                transform: translateY(-3px);
                box-shadow: var(--shadow-xl);
            }

            .edu-btn-success {
                background: var(--gradient-success);
                color: white;
            }

            .edu-btn-warning {
                background: var(--gradient-warm);
                color: white;
            }

            .edu-btn-danger {
                background: linear-gradient(135deg, var(--coral) 0%, #ff5252 100%);
                color: white;
            }

            .edu-btn-info {
                background: linear-gradient(135deg, var(--accent-blue) 0%, #0284c7 100%);
                color: white;
            }

            .edu-btn-info:hover {
                background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
                transform: translateY(-3px);
                box-shadow: var(--shadow-xl);
            }

            .edu-table {
                width: 100%;
                border-collapse: collapse;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 16px;
                overflow: hidden;
                box-shadow: var(--shadow-lg);
                backdrop-filter: blur(10px);
            }

            .edu-table th {
                background: var(--eduflow-dark);
                color: var(--eduflow-light);
                padding: 1.25rem 1rem;
                text-align: left;
                font-weight: 600;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .edu-table td {
                padding: 1.25rem 1rem;
                border-bottom: 1px solid var(--border-light);
                transition: all 0.3s ease;
            }

            .edu-table tr:hover {
                background: rgba(44, 163, 156, 0.05);
                transform: scale(1.01);
            }

            .edu-form-group {
                margin-bottom: 1.5rem;
            }

            .edu-form-label {
                display: block;
                margin-bottom: 0.75rem;
                font-weight: 600;
                color: var(--text-primary);
                font-size: 0.9rem;
            }

            .edu-form-input {
                width: 100%;
                padding: 1rem 1.25rem;
                border: 2px solid var(--border-color);
                border-radius: 16px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
            }

            .edu-form-input:focus {
                outline: none;
                border-color: var(--eduflow-teal);
                box-shadow: 0 0 0 4px rgba(44, 163, 156, 0.1);
                transform: translateY(-2px);
                background: white;
            }

            .edu-form-textarea {
                min-height: 120px;
                resize: vertical;
            }

            .edu-form-select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 1rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 3rem;
                cursor: pointer;
            }

            .edu-alert {
                padding: 1rem 1.5rem;
                border-radius: 16px;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                animation: slideDown 0.5s ease-out;
            }

            .edu-alert-success {
                background: rgba(16, 185, 129, 0.1);
                border: 1px solid rgba(16, 185, 129, 0.2);
                color: #059669;
            }

            .edu-alert-success::before {
                content: '✅';
                font-size: 1.25rem;
            }

            .edu-alert-error {
                background: rgba(239, 68, 68, 0.1);
                border: 1px solid rgba(239, 68, 68, 0.2);
                color: #dc2626;
            }

            .edu-alert-error::before {
                content: '⚠️';
                font-size: 1.25rem;
            }

            .edu-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.375rem 1rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                box-shadow: var(--shadow-sm);
            }

            .edu-badge-instructor {
                background: var(--eduflow-teal);
                color: white;
            }

            .edu-badge-student {
                background: var(--gradient-warm);
                color: white;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .edu-nav {
                    flex-direction: column;
                    gap: 1rem;
                    padding: 1rem;
                }

                .edu-nav-links {
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .edu-card {
                    padding: 1.5rem;
                }

                .edu-table {
                    font-size: 0.875rem;
                }

                .edu-table th,
                .edu-table td {
                    padding: 1rem 0.75rem;
                }

                .edu-main {
                    padding: 5rem 0 2rem 0;
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

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .edu-fade-in {
                animation: slideUp 0.6s ease-out;
            }

            /* Loading States */
            .edu-loading {
                opacity: 0.7;
                pointer-events: none;
            }

            .edu-spinner {
                display: inline-block;
                width: 20px;
                height: 20px;
                border: 3px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                border-top-color: white;
                animation: spin 1s ease-in-out infinite;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }

            .logo-icon {
                display: inline-block;
                position: relative;
                width: 44px;
                height: 44px;
                margin-bottom: 0;
            }
            .book-stack {
                position: absolute;
                width: 36px;
                height: 28px;
                left: 4px;
                top: 8px;
            }
            .book {
                position: absolute;
                width: 36px;
                height: 6px;
                border-radius: 3px;
                box-shadow: 0 1px 4px rgba(0,0,0,0.15);
                opacity: 0;
                transform: translateX(-18px);
            }
            .book-1 {
                background: linear-gradient(135deg, #22d3ee 0%, #0891b2 100%);
                top: 0;
                animation: slideInBook 0.8s ease-out 0.2s forwards, loopAnimation 5s ease-in-out 1s infinite;
            }
            .book-2 {
                background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
                top: 7px;
                animation: slideInBook 0.8s ease-out 0.4s forwards, loopAnimation 5s ease-in-out 1.2s infinite;
            }
            .book-3 {
                background: linear-gradient(135deg, #60a5fa 0%, #2563eb 100%);
                top: 14px;
                animation: slideInBook 0.8s ease-out 0.6s forwards, loopAnimation 5s ease-in-out 1.4s infinite;
            }
            .book-4 {
                background: linear-gradient(135deg, #34d399 0%, #059669 100%);
                top: 21px;
                animation: slideInBook 0.8s ease-out 0.8s forwards, loopAnimation 5s ease-in-out 1.6s infinite;
            }
            .book::before {
                content: '';
                position: absolute;
                right: 3px;
                top: 1px;
                width: 28px;
                height: 4px;
                background: rgba(255,255,255,0.9);
                border-radius: 2px;
                box-shadow: inset 0 0.5px 1px rgba(0,0,0,0.1);
            }
            .book::after {
                content: '';
                position: absolute;
                right: 5px;
                top: 2px;
                width: 1px;
                height: 3px;
                background: rgba(0,0,0,0.1);
                border-radius: 0.5px;
            }
            .graduation-cap {
                position: absolute;
                width: 22px;
                height: 14px;
                left: 10px;
                top: 0;
                opacity: 0;
                transform: scale(0) rotate(45deg);
                animation: bounceInCap 1s ease-out 1.2s forwards, capLoop 5s ease-in-out 2s infinite;
            }
            .cap-top {
                position: absolute;
                width: 22px;
                height: 22px;
                background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
                transform: rotate(45deg);
                border-radius: 3px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.25);
                top: -4px;
            }
            .cap-base {
                position: absolute;
                width: 10px;
                height: 4px;
                background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
                left: 6px;
                top: 7px;
                border-radius: 2px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            }
            .tassel {
                position: absolute;
                width: 1px;
                height: 8px;
                background: linear-gradient(to bottom, #fbbf24, #f59e0b);
                right: 3px;
                top: 5px;
                border-radius: 0.5px;
                opacity: 0;
                animation: tasselDrop 0.6s ease-out 1.8s forwards, tasselSwing 3s ease-in-out 2.5s infinite;
            }
            .tassel::after {
                content: '';
                position: absolute;
                width: 2px;
                height: 2px;
                background: #fbbf24;
                bottom: -1px;
                left: -0.5px;
                border-radius: 50%;
                box-shadow: 0 0.5px 1.5px rgba(0,0,0,0.2);
            }
            .glow-ring {
                position: absolute;
                width: 52px;
                height: 52px;
                left: -4px;
                top: -4px;
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
                left: 7px;
                top: 10px;
                animation: floatParticle 3s ease-in-out 3s infinite;
            }
            .particle-2 {
                right: 7px;
                top: 16px;
                animation: floatParticle 3s ease-in-out 3.5s infinite;
            }
            .particle-3 {
                left: 16px;
                bottom: 10px;
                animation: floatParticle 3s ease-in-out 4s infinite;
            }
            @keyframes slideInBook {
                0% { opacity: 0; transform: translateX(-18px); }
                100% { opacity: 1; transform: translateX(0); }
            }
            @keyframes bounceInCap {
                0% { opacity: 0; transform: scale(0) rotate(45deg); }
                50% { opacity: 1; transform: scale(1.1) rotate(0deg); }
                100% { opacity: 1; transform: scale(1) rotate(0deg); }
            }
            @keyframes tasselDrop {
                0% { opacity: 0; transform: translateY(-3px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            @keyframes expandGlow {
                0% { opacity: 0; transform: scale(0.5); }
                50% { opacity: 1; transform: scale(1.1); }
                100% { opacity: 0.6; transform: scale(1); }
            }
            @keyframes floatParticle {
                0%, 100% { opacity: 0; transform: translateY(0); }
                50% { opacity: 1; transform: translateY(-5px); }
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
            @keyframes glowPulse {
                0%, 100% { opacity: 0.3; transform: scale(1); }
                50% { opacity: 0.8; transform: scale(1.1); }
            }
        </style>
    </head>
    <body>
        <div class="edu-header">
            <div class="edu-container">
                <nav class="edu-nav">
                    <a href="{{ route('dashboard') }}" class="edu-logo">
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
                        EduFlow
                    </a>
                    <div class="edu-nav-links">
                        @auth
                            <a href="{{ route('dashboard') }}" class="edu-nav-link">Dashboard</a>
                            <a href="{{ route('courses.index') }}" class="edu-nav-link">Courses</a>
                            <a href="{{ route('forum.index') }}" class="edu-nav-link">Community</a>
                            <!-- Notification Dropdown -->
                            <div class="edu-dropdown">
                                <button class="edu-nav-link notification-btn" onclick="toggleNotificationDropdown()">
                                    🔔
                                    @php
                                        $unreadCount = auth()->user()->unreadNotifications()->count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="notification-badge">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                                    @endif
                                </button>
                                <div id="notificationDropdown" class="edu-dropdown-menu notification-dropdown" style="display: none;">
                                    <div class="notification-header">
                                        <h3>Notifications</h3>
                                        @if($unreadCount > 0)
                                            <button onclick="markAllAsRead()" class="mark-all-read-btn">Mark all as read</button>
                                        @endif
                                    </div>
                                    <div class="notification-list">
                                        @php
                                            $notifications = auth()->user()->notifications()->with('course')->latest()->take(5)->get();
                                        @endphp
                                        @forelse($notifications as $notification)
                                            <a href="{{ route('notifications.show', $notification) }}" class="notification-item {{ $notification->isRead() ? 'read' : 'unread' }}" style="text-decoration: none;" >
                                                <div class="notification-content">
                                                    <div class="notification-title">{{ $notification->title }}</div>
                                                    <div class="notification-message">{{ Str::limit($notification->message, 60) }}</div>
                                                    @if($notification->course)
                                                        <div class="notification-course">{{ $notification->course->title }}</div>
                                                    @endif
                                                    <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                                @if(!$notification->isRead())
                                                    <div class="unread-indicator"></div>
                                                @endif
                                            </a>
                                        @empty
                                            <div class="no-notifications">
                                                <div class="no-notifications-icon">🔕</div>
                                                <p>No notifications yet</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    @if($notifications->count() > 0)
                                        <div class="notification-footer">
                                            <a href="{{ route('notifications.index') }}" class="view-all-notifications">View all notifications</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="edu-nav-link">🔑 Login</a>
                            <a href="{{ route('register') }}" class="edu-nav-link">📝 Register</a>
                        @endauth
                    </div>
                    @auth
                    <div class="edu-dropdown ml-6">
                        <button class="edu-nav-link flex items-center gap-2" onclick="toggleDropdown()" style="padding: 0.3rem 1rem;">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-9 h-9 rounded-full border-2 border-eduflow-teal shadow-sm object-cover transition-transform duration-200 hover:scale-105" style="background: #f1f5f9;" />
                            @else
                                <span class="w-9 h-9 rounded-full border-2 border-eduflow-teal shadow-sm flex items-center justify-center bg-gray-100 text-gray-400 text-xs font-bold select-none" style="background: #f1f5f9;">Avatar</span>
                            @endif
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            <span class="edu-badge {{ Auth::user()->role === 'instructor' ? 'edu-badge-instructor' : 'edu-badge-student' }}">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </button>
                        <div id="userDropdown" class="edu-dropdown-menu" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="edu-dropdown-item">⚙️ Profile Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="edu-dropdown-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </nav>
            </div>
        </div>

        <main class="edu-main">
            <div class="edu-container">
                @if (session('success'))
                    <div class="edu-alert edu-alert-success edu-fade-in">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="edu-alert edu-alert-error edu-fade-in">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>

        <!-- Enhanced JavaScript -->
        <script>
            // Dropdown functionality
            function toggleDropdown() {
                const dropdown = document.getElementById('userDropdown');
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            }

            // Notification dropdown functionality
            function toggleNotificationDropdown() {
                const dropdown = document.getElementById('notificationDropdown');
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                const userDropdown = document.getElementById('userDropdown');
                const notificationDropdown = document.getElementById('notificationDropdown');
                const userDropdownButton = event.target.closest('.edu-nav-link:not(.notification-btn)');
                const notificationDropdownButton = event.target.closest('.notification-btn');
                
                // Close user dropdown
                if (!userDropdownButton && userDropdown.style.display === 'block') {
                    userDropdown.style.display = 'none';
                }
                
                // Close notification dropdown
                if (!notificationDropdownButton && notificationDropdown.style.display === 'block') {
                    notificationDropdown.style.display = 'none';
                }
            });

            // Mark notification as read
            function markAsRead(notificationId) {
                fetch(`/notifications/${notificationId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the notification item
                        const notificationItem = document.querySelector(`[onclick="markAsRead(${notificationId})"]`);
                        if (notificationItem) {
                            notificationItem.classList.remove('unread');
                            notificationItem.classList.add('read');
                            
                            // Remove unread indicator
                            const unreadIndicator = notificationItem.querySelector('.unread-indicator');
                            if (unreadIndicator) {
                                unreadIndicator.remove();
                            }
                            
                            // Update badge count
                            updateNotificationBadge();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
            }

            // Mark all notifications as read
            function markAllAsRead() {
                fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Update all notification items
                        const unreadItems = document.querySelectorAll('.notification-item.unread');
                        unreadItems.forEach(item => {
                            item.classList.remove('unread');
                            item.classList.add('read');
                            
                            // Remove unread indicators
                            const unreadIndicator = item.querySelector('.unread-indicator');
                            if (unreadIndicator) {
                                unreadIndicator.remove();
                            }
                        });
                        
                        // Update badge count
                        updateNotificationBadge();
                        
                        // Hide mark all as read button
                        const markAllBtn = document.querySelector('.mark-all-read-btn');
                        if (markAllBtn) {
                            markAllBtn.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking all notifications as read:', error);
                });
            }

            // Update notification badge count
            function updateNotificationBadge() {
                const unreadItems = document.querySelectorAll('.notification-item.unread');
                const badge = document.querySelector('.notification-badge');
                
                if (unreadItems.length === 0) {
                    if (badge) {
                        badge.style.display = 'none';
                    }
                } else {
                    if (badge) {
                        badge.textContent = unreadItems.length > 99 ? '99+' : unreadItems.length;
                        badge.style.display = 'block';
                    }
                }
            }

            // Form submission loading states
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            const originalText = submitBtn.innerHTML;
                            submitBtn.classList.add('edu-loading');
                            submitBtn.innerHTML = '<span class="edu-spinner"></span> Processing...';
                            
                            // Reset after 3 seconds if no redirect
                            setTimeout(() => {
                                submitBtn.classList.remove('edu-loading');
                                submitBtn.innerHTML = originalText;
                            }, 3000);
                        }
                    });
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add fade-in animation to cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('edu-fade-in');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.edu-card').forEach(card => {
                observer.observe(card);
            });

            // Enhanced input interactions
            document.querySelectorAll('.edu-form-input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentNode.classList.remove('focused');
                });
            });
        </script>
        <!-- Trix Editor JS -->
        <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('form.delete-comment-form, form.delete-post-form, form.delete-forum-form').forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const message = form.getAttribute('data-message') || 'Are you sure?';
                        Swal.fire({
                            title: 'Confirm Deletion',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    </body>
</html>