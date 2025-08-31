<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EduFlow') }} Admin</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--eduflow-light) 0%, var(--eduflow-gray) 100%);
            color: var(--text-primary);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .admin-sidebar {
            background: var(--eduflow-dark);
            color: var(--eduflow-light);
            width: 280px;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 50;
            box-shadow: var(--shadow-xl);
        }

        .admin-sidebar::before {
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

        .admin-logo {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 10;
        }

        .admin-logo h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--eduflow-teal);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-logo-icon {
            width: 44px;
            height: 44px;
            background: var(--eduflow-teal);
            color: var(--eduflow-dark);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.7rem;
            box-shadow: 0 2px 8px hsla(176, 57.50%, 40.60%, 0.10);
        }

        .admin-nav {
            padding: 1.5rem 0;
            position: relative;
            z-index: 10;
        }

        .admin-nav-section {
            margin-bottom: 2rem;
        }

        .admin-nav-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-light);
            margin: 0 1.5rem 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--eduflow-light);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .admin-nav-link:hover {
            background: rgba(44, 163, 156, 0.1);
            color: var(--eduflow-teal);
            border-left-color: var(--eduflow-teal);
        }

        .admin-nav-link.active {
            background: rgba(44, 163, 156, 0.15);
            color: var(--eduflow-teal);
            border-left-color: var(--eduflow-teal);
        }

        .admin-nav-icon {
            width: 1.25rem;
            text-align: center;
            font-size: 1rem;
        }

        .admin-main {
            margin-left: 280px;
            min-height: 100vh;
            background: var(--eduflow-light);
        }

        .admin-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
        }

        .admin-header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--eduflow-teal);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .admin-user-info {
            text-align: right;
        }

        .admin-user-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .admin-user-role {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        .admin-content {
            padding: 2rem;
        }

        .admin-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .admin-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--light-gray);
        }

        .admin-card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-card-body {
            padding: 2rem;
        }

        .admin-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .admin-btn-primary {
            background: var(--eduflow-teal);
            color: white;
        }

        .admin-btn-primary:hover {
            background: var(--eduflow-accent);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .admin-btn-secondary {
            background: var(--medium-gray);
            color: var(--text-primary);
        }

        .admin-btn-secondary:hover {
            background: var(--border-color);
        }

        .admin-btn-danger {
            background: var(--coral);
            color: white;
        }

        .admin-btn-danger:hover {
            background: #e53e3e;
        }

        .admin-btn-outline {
            background: transparent;
            color: var(--eduflow-teal);
            border: 2px solid var(--eduflow-teal);
        }

        .admin-btn-outline:hover {
            background: var(--eduflow-teal);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .admin-stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .admin-stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .admin-stat-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .admin-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .admin-stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .admin-stat-change {
            font-size: 0.875rem;
            color: var(--accent-green);
            font-weight: 600;
            margin-top: 0.5rem;
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .admin-sidebar.open {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .admin-mobile-toggle {
                display: block;
            }
        }

        .admin-mobile-toggle {
            display: none;
            background: var(--eduflow-teal);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
        }

        .admin-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .admin-overlay.open {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div id="adminOverlay" class="admin-overlay"></div>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-logo">
            <h1>
                <div class="admin-logo-icon">🎓</div>
                EduFlow Admin
            </h1>
        </div>
        
        <nav class="admin-nav">
            <!-- Dashboard Section -->
            <div class="admin-nav-section">
                <div class="admin-nav-title">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-tachometer-alt"></i></span>
                    Dashboard
                </a>
                <a href="{{ route('admin.analytics') }}" class="admin-nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-chart-line"></i></span>
                    Analytics
                </a>
            </div>

            <!-- User Management Section -->
            <div class="admin-nav-section">
                <div class="admin-nav-title">User Management</div>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-users"></i></span>
                    All Users
                </a>

            <!-- Course Management Section -->
            <div class="admin-nav-section">
                <div class="admin-nav-title">Course Management</div>
                <a href="{{ route('admin.courses.index') }}" class="admin-nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-book-open"></i></span>
                    All Courses
            </div>

            <!-- Communication Management Section -->
            <div class="admin-nav-section">
                <div class="admin-nav-title">Communication</div>
                <a href="{{ route('admin.announcements.index') }}" class="admin-nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-bullhorn"></i></span>
                    Announcements
                </a>
                <a href="{{ route('admin.email.index') }}" class="admin-nav-link {{ request()->routeIs('admin.email.*') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-envelope"></i></span>
                    Email System
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="admin-nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-bell"></i></span>
                    Notifications
                </a>
            </div>

            <!-- Forum Management Section -->
            <div class="admin-nav-section">
                <div class="admin-nav-title">Forum Management</div>
                <a href="{{ route('admin.forums.index') }}" class="admin-nav-link {{ request()->routeIs('admin.forums.*') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-comments"></i></span>
                    Forums
                </a>
                <a href="{{ route('admin.forums.posts') }}" class="admin-nav-link {{ request()->routeIs('admin.forums.posts') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-file-alt"></i></span>
                    Posts
                </a>
                <a href="{{ route('admin.forums.comments') }}" class="admin-nav-link {{ request()->routeIs('admin.forums.comments') ? 'active' : '' }}">
                    <span class="admin-nav-icon"><i class="fas fa-comment"></i></span>
                    Comments
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button id="adminMobileToggle" class="admin-mobile-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h2>@yield('page-title', 'Admin Dashboard')</h2>
            </div>
            
            <div class="admin-user-menu">
                <div class="admin-user-info">
                    <div class="admin-user-name">{{ Auth::user()->name }}</div>
                    <div class="admin-user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <div class="admin-user-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-full h-full rounded-full object-cover" />
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-home mr-2"></i> Main Site
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    <script>
        // Mobile sidebar toggle
        const mobileToggle = document.getElementById('adminMobileToggle');
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');

        if (mobileToggle && sidebar && overlay) {
            mobileToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('open');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            });
        }
    </script>
</body>
</html> 