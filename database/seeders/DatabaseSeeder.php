<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        \App\Models\User::create([
            'name' => 'Andre Marc Lads',
            'email' => 's.sambile.andremarc@cmu.edu.ph',
            'password' => Hash::make('2022302902'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        // Seed forums and posts
        $this->call([
            ForumSeeder::class,
        ]);
    }
}
