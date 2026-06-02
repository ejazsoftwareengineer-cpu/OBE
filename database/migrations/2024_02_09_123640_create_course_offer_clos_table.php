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
        Schema::create('course_offer_clos', function (Blueprint $table) {
            $table->id();
            $table->string('code',100)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('courseoffer_id')->nullable();
            $table->integer('domain')->nullable();
            $table->integer('emphasis_level')->nullable();
            $table->integer('level')->nullable();
            $table->string('weight',100)->nullable();
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
        Schema::dropIfExists('course_offer_clos');
    }
};
