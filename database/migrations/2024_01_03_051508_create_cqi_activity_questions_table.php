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
        Schema::create('cqi_activity_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('courseoffer_id')->nullable();
            $table->integer('cqi_activity_id')->nullable();
            $table->string('question_name',100)->nullable();
            $table->string('name',100)->nullable();
            $table->string('answer',100)->nullable();
            $table->string('clo_id',200)->nullable();
            $table->integer('complexity')->nullable();
            $table->text('question')->nullable();
            $table->string('max_mark',10)->nullable();
            $table->string('obe_weight',10)->nullable();
            $table->text('guidline')->nullable();
            $table->text('choices')->nullable();
            $table->integer('not_for_obe')->nullable();
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
        Schema::dropIfExists('cqi_activity_questions');
    }
};
