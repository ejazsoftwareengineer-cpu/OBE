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
        Schema::create('peo', function (Blueprint $table) {
            $table->id();
            $table->string('code',100)->nullable();
            $table->text('description')->nullable();
            $table->text('strategies')->nullable();
            $table->text('element')->nullable();
            $table->integer('program_id')->nullable();
            $table->integer('aligned_mission')->default('0');
            $table->integer('aligned_vision')->default('0');
           $table->integer('status')->default('0')->nullable();
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
        Schema::dropIfExists('peo');
    }
};
