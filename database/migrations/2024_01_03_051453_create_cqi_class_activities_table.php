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
        Schema::create('cqi_class_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('cqi_id')->nullable();
            $table->integer('assesment_id')->nullable();
            $table->integer('course_offer_id')->nullable();
            $table->integer('clo_id')->nullable();
            $table->string('assesment_name',100)->nullable();
            $table->string('assesment_date',100)->nullable();
            $table->string('assesment_total_mark',100)->nullable();
            $table->string('assesment_gpa_weight',100)->nullable();
            $table->integer('complex_engineering_problem')->nullable();
            $table->integer('gpa_calculation')->nullable();
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
        Schema::dropIfExists('cqi_class_activities');
    }
};
