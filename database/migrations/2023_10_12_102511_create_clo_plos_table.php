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
        Schema::create('clo_plos', function (Blueprint $table) {
            $table->id();
            $table->integer('clo_id')->nullable();
            $table->integer('programbatch_id')->nullable();
            $table->integer('plo_id')->nullable();
            $table->integer('domain')->nullable();
            $table->integer('emphasis_level')->nullable();
            $table->integer('level')->nullable();
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
        Schema::dropIfExists('clo_plos');
    }
};
