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
        Schema::create('peo_kpis', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('code',100)->nullable();
            $table->text('description')->nullable();
            $table->integer('peo_id')->nullable();
            $table->integer('measured_when')->nullable();
            $table->text('kpi_percentage',50)->nullable();
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
        Schema::dropIfExists('peo_kpis');
    }
};
