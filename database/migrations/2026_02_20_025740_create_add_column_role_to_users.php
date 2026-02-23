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
        Schema::table('users', function (Blueprint $table) {

            $table->enum('role', ['admin', 'user', 'editor', 'moderator'])
                ->default('user')
                ->after('password');

            $table->string('profile_image')
                ->nullable()
                ->after('role');

            $table->boolean('is_active')
                ->default(true)
                ->after('profile_image');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'profile_image', 'is_active']);
        });
    }
};
