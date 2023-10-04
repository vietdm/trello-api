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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('user_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('boards', function (Blueprint $table) {
            $table->bigInteger('project_id')->after('user_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::table('boards', function (Blueprint $table) {
            $table->dropColumn('project_id');
            $table->dropForeign('project_id');
        });
    }
};
