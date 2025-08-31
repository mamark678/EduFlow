<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rules')->nullable();
            $table->string('banner_url')->nullable();
            $table->integer('member_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->dropForeign(['created_by_user_id']);
            $table->dropColumn(['created_by_user_id', 'rules', 'banner_url', 'member_count']);
        });
    }
}; 