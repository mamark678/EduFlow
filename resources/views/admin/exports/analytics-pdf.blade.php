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
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #183046;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
        }
        .stats-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            flex: 1;
            min-width: 200px;
            text-align: center;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #2ca39c;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }
        .stat-description {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
        }
        .metrics-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .metrics-table th {
            background: #f8f9fa;
            color: #183046;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #e9ecef;
        }
        .metrics-table td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        .metrics-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .highlight {
            background: #e3f2fd;
            color: #1976d2;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .completion-rate {
            font-size: 36px;
            font-weight: bold;
            color: #16a34a;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on {{ $generated_at }}</p>
        <p>EduFlow Learning Management System - Comprehensive Analytics Report</p>
    </div>

    <!-- User Analytics Section -->
    <div class="section">
        <div class="section-title">👥 User Analytics</div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $userAnalytics['total'] }}</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-description">All registered users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $userAnalytics['students'] }}</div>
                <div class="stat-label">Students</div>
                <div class="stat-description">Active learners</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $userAnalytics['instructors'] }}</div>
                <div class="stat-label">Instructors</div>
                <div class="stat-description">Course creators</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $userAnalytics['admins'] }}</div>
                <div class="stat-label">Administrators</div>
                <div class="stat-description">System managers</div>
            </div>
        </div>

        <table class="metrics-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>New Users This Month</td>
                    <td class="highlight">{{ $userAnalytics['this_month'] }}</td>
                    <td>Users registered in the current month</td>
                </tr>
                <tr>
                    <td>Active Users (30 days)</td>
                    <td class="highlight">{{ $userAnalytics['active_users'] }}</td>
                    <td>Users who logged in within the last 30 days</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Course Analytics Section -->
    <div class="section">
        <div class="section-title">📚 Course Analytics</div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $courseAnalytics['total'] }}</div>
                <div class="stat-label">Total Courses</div>
                <div class="stat-description">All created courses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $courseAnalytics['published'] }}</div>
                <div class="stat-label">Published</div>
                <div class="stat-description">Live courses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $courseAnalytics['draft'] }}</div>
                <div class="stat-label">Draft</div>
                <div class="stat-description">Work in progress</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $courseAnalytics['this_month'] }}</div>
                <div class="stat-label">New This Month</div>
                <div class="stat-description">Courses created this month</div>
            </div>
        </div>
    </div>

    <!-- Enrollment Analytics Section -->
    <div class="section">
        <div class="section-title">🎓 Enrollment Analytics</div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $enrollmentAnalytics['total'] }}</div>
                <div class="stat-label">Total Enrollments</div>
                <div class="stat-description">All course enrollments</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $enrollmentAnalytics['completed'] }}</div>
                <div class="stat-label">Completed</div>
                <div class="stat-description">Finished courses</div>
            </div>
            <div class="stat-card">
                <div class="completion-rate">{{ $enrollmentAnalytics['completion_rate'] }}%</div>
                <div class="stat-label">Completion Rate</div>
                <div class="stat-description">Success rate</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $enrollmentAnalytics['this_month'] }}</div>
                <div class="stat-label">New This Month</div>
                <div class="stat-description">Enrollments this month</div>
            </div>
        </div>

        <table class="metrics-table">
            <thead>
                <tr>
                    <th>Metric</th>
                    <th>Value</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Enrollments</td>
                    <td class="highlight">{{ $enrollmentAnalytics['total'] }}</td>
                    <td>All course enrollments in the system</td>
                </tr>
                <tr>
                    <td>Completed Enrollments</td>
                    <td class="highlight">{{ $enrollmentAnalytics['completed'] }}</td>
                    <td>Students who finished their courses</td>
                </tr>
                <tr>
                    <td>Completion Rate</td>
                    <td class="highlight">{{ $enrollmentAnalytics['completion_rate'] }}%</td>
                    <td>Percentage of completed enrollments</td>
                </tr>
                <tr>
                    <td>New Enrollments This Month</td>
                    <td class="highlight">{{ $enrollmentAnalytics['this_month'] }}</td>
                    <td>Enrollments created this month</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>This comprehensive analytics report was generated automatically by the EduFlow Admin Panel</p>
        <p>For questions or support, please contact the system administrator</p>
        <p>Report includes real-time data as of {{ $generated_at }}</p>
    </div>
</body>
</html> 