<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2ca39c;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #183046;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filters {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2ca39c;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            color: #183046;
            font-size: 14px;
        }
        .filters p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #183046;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .role-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .role-admin { background: #fee2e2; color: #dc2626; }
        .role-instructor { background: #dbeafe; color: #2563eb; }
        .role-student { background: #dcfce7; color: #16a34a; }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            flex: 1;
            margin: 0 5px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #2ca39c;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on {{ $generated_at }}</p>
        <p>EduFlow Learning Management System</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-number">{{ $total_users }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $users->where('role', 'student')->count() }}</div>
            <div class="stat-label">Students</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $users->where('role', 'instructor')->count() }}</div>
            <div class="stat-label">Instructors</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $users->where('role', 'admin')->count() }}</div>
            <div class="stat-label">Admins</div>
        </div>
    </div>

    @if($filters['search'] || $filters['role'] || $filters['email_verified'])
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if($filters['search'])
            <p><strong>Search:</strong> {{ $filters['search'] }}</p>
        @endif
        @if($filters['role'])
            <p><strong>Role:</strong> {{ ucfirst($filters['role']) }}</p>
        @endif
        @if($filters['email_verified'] !== null)
            <p><strong>Email Verified:</strong> {{ $filters['email_verified'] ? 'Yes' : 'No' }}</p>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Email Verified</th>
                <th>Courses Created</th>
                <th>Enrollments</th>
                <th>Comments</th>
                <th>Last Login</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="role-badge role-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->email_verified ? 'Yes' : 'No' }}</td>
                <td>{{ $user->courses_count }}</td>
                <td>{{ $user->enrollments_count }}</td>
                <td>{{ $user->comments_count }}</td>
                <td>{{ $user->last_login_at ? $user->last_login_at->format('M j, Y') : 'Never' }}</td>
                <td>{{ $user->created_at->format('M j, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the EduFlow Admin Panel</p>
        <p>For questions or support, please contact the system administrator</p>
    </div>
</body>
</html> 