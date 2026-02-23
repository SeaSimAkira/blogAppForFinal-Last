<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // This must match the options in your Controller validation exactly
            $table->enum('role', ['admin', 'user', 'editor', 'viewer', 'contributor'])
                  ->default('user')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert back to the original restricted list if needed
            $table->enum('role', ['admin', 'user'])->change();
        });
    }
};