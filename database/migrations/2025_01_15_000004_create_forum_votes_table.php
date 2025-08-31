<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('votable'); // votable_type, votable_id
            $table->enum('vote_type', ['upvote', 'downvote']);
            $table->timestamps();

            // Ensure a user can only vote once per post/comment
            $table->unique(['user_id', 'votable_type', 'votable_id']);
            
            // Indexes for performance
            $table->index(['user_id', 'vote_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_votes');
    }
}; 