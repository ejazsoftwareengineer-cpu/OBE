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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('sap_course_id')->nullable();
            $table->string('name',100)->nullable();
            $table->string('code',50)->unique();
            $table->string('theory',50)->nullable();
            $table->string('lab',50)->nullable();
            $table->string('tutorial',50)->nullable();
            $table->string('obe_mapping',50)->nullable();
            $table->text('description')->nullable();
            $table->integer('program_id')->nullable();
            // $table->integer('program_batch_id')->nullable();
            // $table->integer('institute_id')->nullable();
            // $table->integer('department_id')->nullable();
            $table->integer('delivery_format')->nullable();
            $table->integer('course_level')->comment("comment")->nullable();
            $table->integer('based_type')->comment("comment")->nullable();
            $table->integer('clo_id')->nullable();
            $table->integer('status')->comment("comment")->default('0');
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
        Schema::dropIfExists('courses');
    }
};
