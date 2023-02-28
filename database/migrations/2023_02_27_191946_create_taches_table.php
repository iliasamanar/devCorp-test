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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin')->nullable();
            $table->unsignedBigInteger('member')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('description')->nullable();
            $table->enum('status',['pending','cancelled','completed'])->default('pending');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('admin')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('member')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
