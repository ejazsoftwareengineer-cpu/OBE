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
        Schema::create('clo', function (Blueprint $table) {
            $table->id();
            $table->string('code',100)->nullable();
            $table->string('weight',100)->nullable();
            $table->string('type',50)->default('Null')->nullable();
            $table->text('description')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('domain')->nullable();
            $table->integer('emphasis_level')->nullable();
            $table->integer('level')->nullable();
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('clo');
    }
};
