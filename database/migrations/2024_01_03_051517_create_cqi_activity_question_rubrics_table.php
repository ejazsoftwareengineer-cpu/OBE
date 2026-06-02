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
        Schema::create('cqi_activity_question_rubrics', function (Blueprint $table) {
            $table->id();
            $table->integer('cqi_question_id')->nullable();
            $table->integer('cqi_activity_id')->nullable();
            $table->text('scale_1')->nullable();
            $table->text('scale_2')->nullable();
            $table->text('scale_3')->nullable();
            $table->text('scale_4')->nullable();
            $table->text('scale_5')->nullable();
            $table->text('scale_6')->nullable();
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
        Schema::dropIfExists('cqi_activity_question_rubrics');
    }
};
