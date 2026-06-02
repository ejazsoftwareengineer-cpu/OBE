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
        Schema::create('program_batches', function (Blueprint $table) {
            $table->id(); 
            $table->string('acedemic_year',100)->nullable();
            $table->integer('program_id')->nullable();
            $table->integer('cirriculum_id')->nullable();
            $table->integer('no_of_session')->default('0');
            $table->string('theory_crdit_hr',100)->nullable();
            $table->string('lab_crdit_hr',100)->nullable();
            $table->text('description')->nullable();
            $table->integer('use_in_obe')->comment("comment")->default('0');
            $table->string('gpa_method',10)->comment("comment")->nullable();
            $table->string('mark_per',10)->nullable();
            $table->string('student_per',10)->nullable();
            $table->string('name',100)->nullable();
            $table->string('plo_passing_threshold',10)->comment("comment")->nullable();
            $table->string('start_date',30)->nullable();
            $table->string('end_date',30)->nullable();
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
        Schema::dropIfExists('program_batches');
    }
};
