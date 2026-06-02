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
        Schema::create('student_question_attainments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('clo_id');
            $table->unsignedBigInteger('courseoffer_id');
            $table->unsignedBigInteger('question_id')->nullable();
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->unsignedBigInteger('cqi_question_id')->nullable();
            $table->unsignedBigInteger('cqi_activity_id')->nullable();
            $table->decimal('obtained_marks', 8, 2)->default(0);
            $table->decimal('max_marks', 8, 2)->default(0);
            $table->decimal('obe_weight', 8, 2)->default(0);
            $table->decimal('percentage', 8, 2)->default(0);
            $table->enum('achieved_flag', ['Y', 'N'])->default('N');
            $table->timestamps();

            $table->index(['student_id', 'clo_id', 'courseoffer_id'], 'idx_student_question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_question_attainments');
    }
};
