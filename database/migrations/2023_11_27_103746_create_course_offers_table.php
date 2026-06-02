<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_offers', function (Blueprint $table) {
            $table->id();
            $table->integer('active_session_id')->nullable();
            $table->integer('institute_id')->nullable();
            $table->integer('program_id')->nullable();
            $table->integer('cirriculum_id')->nullable();
            $table->integer('semester')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('course_status')->nullable();
            $table->integer('gender')->nullable();
            $table->string('name',100)->nullable();
            $table->string('section')->nullable();
            $table->string('mark_per',10)->nullable();
            $table->string('student_per',10)->nullable();
            $table->string('available_seats',10)->nullable();
            $table->text('office_hours')->nullable();
            $table->text('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_offers');
    }
};
