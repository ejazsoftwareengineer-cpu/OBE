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
        Schema::create('plo_kpis', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('code',100)->nullable();
            $table->text('description')->nullable();
            $table->integer('plo_id')->nullable();
            $table->string('measured_when',50)->nullable();
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
        Schema::dropIfExists('plo_kpis');
    }
};
