<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * D:\wamp\www\pms_system\database\migrations\2024_02_29_133046_add_force_password_reset_to_users_table.php
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('force_password_reset')->default(true);
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
