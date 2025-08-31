<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forums = [
            [
                'name' => 'General Discussion',
                'description' => 'Talk about anything related to the platform or learning.',
                'icon' => '💬',
                'color' => '#3b82f6',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Study Tips',
                'description' => 'Share your best study strategies and tips.',
                'icon' => '📚',
                'color' => '#10b981',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Course Feedback',
                'description' => 'Give feedback and suggestions for courses.',
                'icon' => '⭐',
                'color' => '#f59e0b',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Tech Support',
                'description' => 'Get help with technical issues.',
                'icon' => '🔧',
                'color' => '#ef4444',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Off Topic',
                'description' => 'Discuss anything not directly related to courses.',
                'icon' => '🎵',
                'color' => '#8b5cf6',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($forums as $forum) {
            Forum::create($forum);
        }
    }
} 