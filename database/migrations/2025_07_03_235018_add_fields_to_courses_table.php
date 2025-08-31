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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description');
            $table->string('difficulty')->nullable()->after('category');
            $table->integer('duration')->nullable()->after('difficulty');
            $table->integer('max_students')->nullable()->after('duration');
            $table->text('prerequisites')->nullable()->after('max_students');
            $table->text('learning_objectives')->nullable()->after('prerequisites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'difficulty',
                'duration',
                'max_students',
                'prerequisites',
                'learning_objectives'
            ]);
        });
    }
};
