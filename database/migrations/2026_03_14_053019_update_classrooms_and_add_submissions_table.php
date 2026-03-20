<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update Classrooms
        Schema::table('classrooms', function (Blueprint $table) {
            $table->string('enroll_code')->nullable()->after('name');
        });

        // Update Classroom User Pivot
        Schema::table('classroom_user', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('user_id'); // pending, approved, rejected
        });

        // Create Task Submissions
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('submitted'); // submitted, reviewed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
        
        Schema::table('classroom_user', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn('enroll_code');
        });
    }
};
