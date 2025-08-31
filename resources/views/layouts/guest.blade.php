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

        <!-- Enhanced Guest Layout CSS -->
        <style>
            :root {
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
                --gradient-primary: linear-gradient(135deg, #14b8a6 0%, #0e7490 100%);
                --gradient-accent: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                --gradient-warm: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            }

            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: var(--gradient-primary);
                background-attachment: fixed;
                color: var(--text-primary);
                line-height: 1.6;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow-x: hidden;
            }

            /* Animated Background Elements */
            body::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
                z-index: -1;
            }

            .auth-container {
                width: 100%;
                max-width: 450px;
                padding: 2rem;
                position: relative;
                z-index: 10;
            }

            .auth-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-radius: 24px;
                box-shadow: var(--shadow-xl);
                padding: 3rem;
                border: 1px solid rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
                animation: slideUp 0.8s ease-out;
            }

            .auth-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: var(--gradient-primary);
            }

            .auth-header {
                text-align: center;
                margin-bottom: 2.5rem;
            }

            .auth-logo {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 1.5rem;
                text-decoration: none;
                color: var(--text-primary);
            }

            .auth-logo-icon {
                width: 50px;
                height: 50px;
                background: var(--gradient-primary);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
                font-size: 1.5rem;
                box-shadow: var(--shadow-md);
            }

            .auth-logo-text {
                font-family: 'Poppins', sans-serif;
                font-size: 1.75rem;
                font-weight: 700;
            }

            .auth-title {
                font-family: 'Poppins', sans-serif;
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--text-primary);
                margin-bottom: 0.5rem;
            }

            .auth-subtitle {
                color: var(--text-secondary);
                font-size: 1rem;
                margin-bottom: 0;
            }

            .auth-form-group {
                margin-bottom: 1.5rem;
                position: relative;
            }

            .auth-form-label {
                display: block;
                margin-bottom: 0.75rem;
                font-weight: 600;
                color: var(--text-primary);
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .auth-form-input {
                width: 100%;
                padding: 1rem 1.25rem;
                border: 2px solid var(--border-color);
                border-radius: 16px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                color: var(--text-primary);
            }

            .auth-form-input:focus {
                outline: none;
                border-color: var(--primary-blue);
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
                transform: translateY(-2px);
                background: white;
            }

            .auth-form-input::placeholder {
                color: var(--text-light);
            }

            .auth-form-select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 1rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 3rem;
                cursor: pointer;
            }

            .auth-checkbox {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 2rem;
            }

            .auth-checkbox input[type="checkbox"] {
                width: 20px;
                height: 20px;
                border: 2px solid var(--border-color);
                border-radius: 6px;
                cursor: pointer;
                accent-color: var(--primary-blue);
            }

            .auth-checkbox-label {
                color: var(--text-secondary);
                font-size: 0.9rem;
                cursor: pointer;
                user-select: none;
            }

            .auth-btn {
                width: 100%;
                padding: 1rem 2rem;
                border-radius: 16px;
                font-weight: 600;
                font-size: 1rem;
                border: none;
                cursor: pointer;
                transition: all 0.4s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                text-decoration: none;
                margin-bottom: 1rem;
                position: relative;
                overflow: hidden;
                box-shadow: var(--shadow-md);
            }

            .auth-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: all 0.5s ease;
            }

            .auth-btn:hover::before {
                left: 100%;
            }

            .auth-btn-primary {
                background: var(--gradient-primary);
                color: white;
            }

            .auth-btn-primary:hover {
                transform: translateY(-3px);
                box-shadow: var(--shadow-xl);
            }

            .auth-btn-secondary {
                background: rgba(255, 255, 255, 0.9);
                color: var(--text-primary);
                border: 2px solid rgba(255, 255, 255, 0.3);
            }

            .auth-btn-secondary:hover {
                background: white;
                transform: translateY(-3px);
                box-shadow: var(--shadow-xl);
            }

            .auth-divider {
                text-align: center;
                margin: 2rem 0;
                position: relative;
            }

            .auth-divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: var(--border-color);
            }

            .auth-divider-text {
                background: rgba(255, 255, 255, 0.95);
                padding: 0 1rem;
                color: var(--text-secondary);
                font-size: 0.9rem;
                position: relative;
                z-index: 1;
            }

            .auth-links {
                text-align: center;
                margin: 1.5rem 0;
            }

            .auth-link {
                color: var(--primary-blue);
                text-decoration: none;
                font-weight: 500;
                font-size: 0.9rem;
                transition: all 0.3s ease;
                position: relative;
            }

            .auth-link::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background: var(--primary-blue);
                transition: width 0.3s ease;
            }

            .auth-link:hover::after {
                width: 100%;
            }

            .auth-link:hover {
                color: var(--secondary-blue);
            }

            .auth-error {
                color: var(--coral);
                font-size: 0.875rem;
                margin-top: 0.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .auth-error::before {
                content: '⚠️';
                font-size: 0.75rem;
            }

            .auth-success {
                background: rgba(16, 185, 129, 0.1);
                color: #059669;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                margin-bottom: 2rem;
                border: 1px solid rgba(16, 185, 129, 0.2);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                animation: slideDown 0.5s ease-out;
            }

            .auth-success::before {
                content: '✅';
                font-size: 1.25rem;
            }

            /* Floating Animation Elements */
            .floating-shapes {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 1;
            }

            .shape {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.1);
                animation: float 8s ease-in-out infinite;
            }

            .shape:nth-child(1) {
                width: 100px;
                height: 100px;
                top: 20%;
                left: 10%;
                animation-delay: 0s;
            }

            .shape:nth-child(2) {
                width: 60px;
                height: 60px;
                top: 60%;
                right: 10%;
                animation-delay: 2s;
            }

            .shape:nth-child(3) {
                width: 80px;
                height: 80px;
                bottom: 20%;
                left: 20%;
                animation-delay: 4s;
            }

            .shape:nth-child(4) {
                width: 120px;
                height: 120px;
                top: 10%;
                right: 20%;
                animation-delay: 6s;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .auth-container {
                    padding: 1rem;
                }

                .auth-card {
                    padding: 2rem;
                }

                .auth-title {
                    font-size: 1.5rem;
                }

                .auth-subtitle {
                    font-size: 0.9rem;
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

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                25% { transform: translateY(-20px) rotate(90deg); }
                50% { transform: translateY(-10px) rotate(180deg); }
                75% { transform: translateY(-30px) rotate(270deg); }
            }

            /* Loading States */
            .auth-loading {
                opacity: 0.7;
                pointer-events: none;
            }

            .auth-spinner {
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
        </style>
    </head>
    <body>
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <a href="#" class="auth-logo">
                        <div class="auth-logo-icon">E</div>
                        <span class="auth-logo-text">EduFlow</span>
                </a>
            </div>

                {{ $slot }}
            </div>
        </div>

        <!-- Enhanced JavaScript -->
        <script>
            // Form submission loading states
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        const submitBtn = this.querySelector('.auth-btn-primary');
                        if (submitBtn) {
                            const originalText = submitBtn.innerHTML;
                            submitBtn.classList.add('auth-loading');
                            submitBtn.innerHTML = '<span class="auth-spinner"></span> Processing...';
                            
                            // Reset after 3 seconds if no redirect
                            setTimeout(() => {
                                submitBtn.classList.remove('auth-loading');
                                submitBtn.innerHTML = originalText;
                            }, 3000);
                        }
                    });
                });
            });

            // Enhanced input interactions
            document.querySelectorAll('.auth-form-input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentNode.classList.remove('focused');
                });
            });

            // Smooth animations for form elements
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.auth-form-group').forEach(group => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                group.style.transition = 'all 0.6s ease-out';
                observer.observe(group);
            });
        </script>
    </body>
</html>
