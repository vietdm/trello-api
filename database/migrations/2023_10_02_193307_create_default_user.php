<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::insert([
            'name' => 'Administrator',
            'email' => 'admin@dev.local',
            'password' => bcrypt('admin1')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /// void function
    }
};
