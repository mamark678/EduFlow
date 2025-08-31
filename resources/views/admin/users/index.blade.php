@extends('admin.layouts.app')

@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-users"></i>
                User Management
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Account creation, role assignment, and permission settings for students, instructors, and administrators
            </p>
        </div>
        <div class="admin-card-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin: 0;">
                        Manage Users
                    </h2>
                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                        Create, edit, and manage user accounts with comprehensive role-based permissions
                    </p>
                </div>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="#" class="admin-btn admin-btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Create User
                    </a>
                    <a href="{{ route('admin.export.users.csv') }}" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-download"></i>
                        Export Users (CSV)
                    </a>
                    <a href="{{ route('admin.export.users.pdf') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-file-pdf"></i>
                        Export Users (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; border: 1px solid #10b981; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;" id="successAlert">
            <div style="display: flex; align-items: center;">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" style="margin-left: auto; color: #10b981; background: none; border: none; cursor: pointer;" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <script>
            setTimeout(function() {
                const alert = document.getElementById('successAlert');
                if (alert) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #f87171; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center;">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
                <button type="button" style="margin-left: auto; color: #dc2626; background: none; border: none; cursor: pointer;" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Search and Filter Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-search"></i>
                Search & Filter Users
            </h3>
        </div>
        <div class="admin-card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Search Users</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name or email..." 
                           style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem;">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Role</label>
                    <select name="role" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem;">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>Instructor</option>
                        <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Email Status</label>
                    <select name="email_verified" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.875rem;">
                        <option value="">All Users</option>
                        <option value="1" {{ request('email_verified') == '1' ? 'selected' : '' }}>Verified</option>
                        <option value="0" {{ request('email_verified') == '0' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                    @if(request('search') || request('role') || request('email_verified'))
                        <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-secondary">
                            <i class="fas fa-times"></i>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Total Users</div>
                <div class="admin-stat-icon" style="background: var(--primary-blue);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ $users->total() }}</div>
            <div class="admin-stat-change">+12% from last month</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Admin Users</div>
                <div class="admin-stat-icon" style="background: var(--coral);">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
            <div class="admin-stat-change">System administrators</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Instructors</div>
                <div class="admin-stat-icon" style="background: var(--accent-blue);">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\User::where('role', 'instructor')->count() }}</div>
            <div class="admin-stat-change">Course creators</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Students</div>
                <div class="admin-stat-icon" style="background: var(--accent-green);">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\User::where('role', 'student')->count() }}</div>
            <div class="admin-stat-change">Active learners</div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="admin-card-title">
                    <i class="fas fa-list"></i>
                    Users List
                    @if(request('search') || request('role') || request('email_verified'))
                        <span style="font-size: 0.875rem; color: var(--text-secondary); font-weight: normal;">(Filtered results)</span>
                    @endif
                </h3>
                <div style="color: var(--text-secondary); font-size: 0.875rem;">
                    Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                </div>
            </div>
        </div>

        <div class="admin-card-body" style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: var(--light-gray);">
                        <tr>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">ID</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">User</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">Email</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">Role</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">Status</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">Created</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary); border-bottom: 1px solid var(--border-color);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr style="border-bottom: 1px solid var(--border-light);">
                                <td style="padding: 1rem; color: var(--text-primary);">{{ $user->id }}</td>
                                <td style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--eduflow-teal); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.875rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: var(--text-primary);">{{ $user->name }}</div>
                                            @if($user->id == auth()->id())
                                                <small style="color: var(--accent-green);">(Current User)</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem; color: var(--text-primary);">{{ $user->email }}</td>
                                <td style="padding: 1rem;">
                                    @if($user->role === 'admin')
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #fee2e2; color: #dc2626;">
                                            <i class="fas fa-crown mr-1"></i> Admin
                                        </span>
                                    @elseif($user->role === 'instructor')
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #2563eb;">
                                            <i class="fas fa-chalkboard-teacher mr-1"></i> Instructor
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dcfce7; color: #16a34a;">
                                            <i class="fas fa-user-graduate mr-1"></i> Student
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    @if($user->email_verified)
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dcfce7; color: #16a34a;">
                                            <i class="fas fa-check-circle mr-1"></i> Verified
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #fef3c7; color: #d97706;">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Unverified
                                        </span>
                                    @endif
                                </td>
                                <td style="padding: 1rem; color: var(--text-secondary);">
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-primary);">{{ $user->created_at->format('M j, Y') }}</div>
                                        <small>{{ $user->created_at->format('g:i A') }}</small>
                                    </div>
                                </td>
                                <td style="padding: 1rem; text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <a href="{{ route('admin.users.show', $user) }}" class="admin-btn" style="padding: 0.5rem; background: var(--accent-blue); color: white;" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="admin-btn" style="padding: 0.5rem; background: var(--warm-orange); color: white;" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id != auth()->id())
                                            <button type="button" class="admin-btn" style="padding: 0.5rem; background: var(--coral); color: white;" 
                                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="admin-btn" style="padding: 0.5rem; background: var(--text-light); color: white; cursor: not-allowed;" disabled title="Cannot delete yourself">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 3rem; text-align: center; color: var(--text-secondary);">
                                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: var(--text-light);"></i>
                                    <h5 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">No users found</h5>
                                    <p>No users match your search criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center;">
                <nav style="display: flex; gap: 0.25rem;">
                    {{-- Previous Page Link --}}
                    @if ($users->onFirstPage())
                        <span style="padding: 0.5rem 0.75rem; color: var(--text-light); background: var(--light-gray); border-radius: 6px; cursor: not-allowed;">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" style="padding: 0.5rem 0.75rem; color: var(--text-primary); background: white; border: 1px solid var(--border-color); border-radius: 6px; text-decoration: none; transition: all 0.2s;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();
                        $showPages = 5;
                        $halfShow = floor($showPages / 2);

                        if ($lastPage <= $showPages) {
                            $startPage = 1;
                            $endPage = $lastPage;
                        } else {
                            if ($currentPage <= $halfShow + 1) {
                                $startPage = 1;
                                $endPage = $showPages;
                            } elseif ($currentPage >= $lastPage - $halfShow) {
                                $startPage = $lastPage - $showPages + 1;
                                $endPage = $lastPage;
                            } else {
                                $startPage = $currentPage - $halfShow;
                                $endPage = $currentPage + $halfShow;
                            }
                        }
                    @endphp

                    {{-- First page and ellipsis --}}
                    @if ($startPage > 1)
                        <a href="{{ $users->url(1) }}" style="padding: 0.5rem 0.75rem; color: var(--text-primary); background: white; border: 1px solid var(--border-color); border-radius: 6px; text-decoration: none; transition: all 0.2s;">1</a>
                        @if ($startPage > 2)
                            <span style="padding: 0.5rem 0.75rem; color: var(--text-light);">...</span>
                        @endif
                    @endif

                    {{-- Page numbers --}}
                    @for ($page = $startPage; $page <= $endPage; $page++)
                        @if ($page == $currentPage)
                            <span style="padding: 0.5rem 0.75rem; color: white; background: var(--eduflow-teal); border-radius: 6px;">{{ $page }}</span>
                        @else
                            <a href="{{ $users->url($page) }}" style="padding: 0.5rem 0.75rem; color: var(--text-primary); background: white; border: 1px solid var(--border-color); border-radius: 6px; text-decoration: none; transition: all 0.2s;">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Last page and ellipsis --}}
                    @if ($endPage < $lastPage)
                        @if ($endPage < $lastPage - 1)
                            <span style="padding: 0.5rem 0.75rem; color: var(--text-light);">...</span>
                        @endif
                        <a href="{{ $users->url($lastPage) }}" style="padding: 0.5rem 0.75rem; color: var(--text-primary); background: white; border: 1px solid var(--border-color); border-radius: 6px; text-decoration: none; transition: all 0.2s;">{{ $lastPage }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" style="padding: 0.5rem 0.75rem; color: var(--text-primary); background: white; border: 1px solid var(--border-color); border-radius: 6px; text-decoration: none; transition: all 0.2s;">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span style="padding: 0.5rem 0.75rem; color: var(--text-light); background: var(--light-gray); border-radius: 6px; cursor: not-allowed;">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000;">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">
        <div style="background: white; border-radius: 16px; box-shadow: var(--shadow-xl); max-width: 400px; width: 100%;">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color);">
                <h5 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Confirm Delete</h5>
            </div>
            <div style="padding: 1.5rem 2rem;">
                <p style="color: var(--text-primary); margin-bottom: 1rem;">Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p style="color: var(--coral); font-size: 0.875rem; margin: 0;">This action cannot be undone.</p>
            </div>
            <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--border-color); display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeDeleteModal()" class="admin-btn admin-btn-secondary">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn-danger">
                        Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(userId, userName) {
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deleteForm').action = `/admin/users/${userId}`;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection 