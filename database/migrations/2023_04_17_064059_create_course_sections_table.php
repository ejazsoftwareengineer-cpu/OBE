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
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('institute_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->integer('teacher_id')->nullable();
           $table->integer('status')->default('0')->nullable();
            $table->integer('course_status')->comment("comment")->default('0');
            $table->integer('gender')->comment("comment")->default('0');
            $table->string('name',100)->nullable();
            $table->string('section')->comment("comment")->default('0');
            $table->string('mark_per',10)->nullable();
            $table->string('student_per',10)->nullable();
            $table->string('available_seats',10)->comment("comment")->nullable();
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
        Schema::dropIfExists('course_sections');
    }
};
