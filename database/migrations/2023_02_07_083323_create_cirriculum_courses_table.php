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
        Schema::create('cirriculum_courses', function (Blueprint $table) {
            $table->id();
            $table->string('semester',100)->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('cirriculum_id')->nullable();
           $table->integer('status')->default('0')->nullable();
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
        Schema::dropIfExists('cirriculum_courses');
    }
};
