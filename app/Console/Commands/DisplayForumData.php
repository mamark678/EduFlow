<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Forum;
use App\Models\ForumPost;

class DisplayForumData extends Command
{
    protected $signature = 'forum:display-data';
    protected $description = 'Display all forums and their posts';

    public function handle()
    {
        $this->info('=== FORUMS ===');
        $this->newLine();
        
        $forums = Forum::withCount(['posts', 'comments'])->get();
        
        foreach ($forums as $forum) {
            $this->line("📁 <fg=blue>{$forum->name}</fg=blue>");
            $this->line("   {$forum->description}");
            $this->line("   Posts: {$forum->posts_count} | Comments: {$forum->comments_count}");
            $this->line("   Created: {$forum->created_at->diffForHumans()}");
            $this->newLine();
        }
        
        $this->info('=== POSTS ===');
        $this->newLine();
        
        $posts = ForumPost::with(['forum', 'user'])->orderBy('created_at', 'desc')->get();
        
        foreach ($posts as $post) {
            $score = $post->upvotes - $post->downvotes;
            $scoreColor = $score > 0 ? 'green' : ($score < 0 ? 'red' : 'yellow');
            
            $this->line("📝 <fg=blue>{$post->forum->name}</fg=blue>: {$post->title}");
            $this->line("   By: {$post->user->name} | <fg={$scoreColor}>{$score} votes</fg={$scoreColor}> | {$post->views} views | {$post->comments_count} comments");
            $this->line("   Type: {$post->type} | Created: {$post->created_at->diffForHumans()}");
            $this->newLine();
        }
        
        $this->info("Total Forums: {$forums->count()}");
        $this->info("Total Posts: {$posts->count()}");
        
        return 0;
    }
} 