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
        Schema::create('peo_programs', function (Blueprint $table) {
            $table->id();
            $table->integer('peo_id')->nullable();
            $table->integer('program_id')->nullable();
            $table->integer('program_vision')->default('0')->nullable();
            $table->integer('program_mission')->default('0')->nullable();
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
        Schema::dropIfExists('peo_programs');
    }
};
