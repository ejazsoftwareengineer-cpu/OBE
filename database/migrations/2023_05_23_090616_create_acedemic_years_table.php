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
        Schema::create('acedemic_years', function (Blueprint $table) {
            $table->id();
            $table->string('start_date',30)->nullable();
            $table->string('end_date',30)->nullable();
            $table->string('name',100)->nullable();
           $table->integer('status')->default('0')->nullable();
            $table->string('type',30)->nullable();
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
        Schema::dropIfExists('acedemic_years');
    }
};
