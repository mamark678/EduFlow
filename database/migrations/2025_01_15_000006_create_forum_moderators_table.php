<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forum_moderators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('permissions')->nullable(); // ['moderate_posts', 'moderate_comments', 'manage_forum', 'appoint_moderators']
            $table->timestamp('appointed_at')->useCurrent();
            $table->foreignId('appointed_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['forum_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('forum_moderators');
    }
}; 