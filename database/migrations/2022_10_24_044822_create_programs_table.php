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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->integer('sap_program_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('institute_id')->nullable();
            $table->integer('no_of_session')->comment("comment")->nullable();
            $table->string('mark_per',100)->nullable();
            $table->integer('assessment_method')->comment("comment")->nullable();
            $table->text('vision')->nullable();
            $table->integer('status')->comment("comment")->default('0');
            $table->integer('session_type')->comment("comment")->nullable();
            $table->integer('program_level')->comment("comment")->nullable();
            $table->string('program_type',10)->comment("comment")->nullable();
            $table->string('student_per',100)->nullable();
            $table->integer('learning_type_category')->comment("comment")->nullable();
            $table->text('mission')->nullable();
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
        Schema::dropIfExists('programs');
    }
};
