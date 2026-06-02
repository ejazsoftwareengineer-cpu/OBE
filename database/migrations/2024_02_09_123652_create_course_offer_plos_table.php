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
        Schema::create('course_offer_plos', function (Blueprint $table) {
            $table->id();
            $table->integer('clo_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('course_section_id')->nullable();
            $table->integer('plo_id')->nullable();
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
        Schema::dropIfExists('course_offer_plos');
    }
};
