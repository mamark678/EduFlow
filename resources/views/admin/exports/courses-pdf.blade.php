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
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-published { background: #dcfce7; color: #16a34a; }
        .status-draft { background: #fef3c7; color: #d97706; }
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
        .description {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            <div class="stat-number">{{ $total_courses }}</div>
            <div class="stat-label">Total Courses</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $courses->where('is_published', true)->count() }}</div>
            <div class="stat-label">Published</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $courses->where('is_published', false)->count() }}</div>
            <div class="stat-label">Draft</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $courses->sum('enrollments_count') }}</div>
            <div class="stat-label">Total Enrollments</div>
        </div>
    </div>

    @if($filters['search'] || $filters['instructor'] || $filters['published'] !== null)
    <div class="filters">
        <h3>Applied Filters:</h3>
        @if($filters['search'])
            <p><strong>Search:</strong> {{ $filters['search'] }}</p>
        @endif
        @if($filters['instructor'])
            <p><strong>Instructor:</strong> {{ \App\Models\User::find($filters['instructor'])->name ?? 'Unknown' }}</p>
        @endif
        @if($filters['published'] !== null)
            <p><strong>Status:</strong> {{ $filters['published'] ? 'Published' : 'Draft' }}</p>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Instructor</th>
                <th>Category</th>
                <th>Difficulty</th>
                <th>Modules</th>
                <th>Enrollments</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td class="description" title="{{ $course->description }}">{{ $course->description }}</td>
                <td>{{ $course->instructor->name }}</td>
                <td>{{ $course->category ?? 'N/A' }}</td>
                <td>{{ ucfirst($course->difficulty ?? 'N/A') }}</td>
                <td>{{ $course->modules_count ?? 0 }}</td>
                <td>{{ $course->enrollments_count ?? 0 }}</td>
                <td>
                    <span class="status-badge status-{{ $course->is_published ? 'published' : 'draft' }}">
                        {{ $course->is_published ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td>{{ $course->created_at->format('M j, Y') }}</td>
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