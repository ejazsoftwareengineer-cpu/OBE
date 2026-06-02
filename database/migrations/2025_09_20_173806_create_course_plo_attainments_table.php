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
        Schema::create('course_plo_attainments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('plo_id');
                $table->unsignedBigInteger('courseoffer_id');
                $table->decimal('average_attainment', 8, 2)->default(0);
                $table->enum('achieved_flag', ['Y', 'N'])->default('N');
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
        Schema::dropIfExists('course_plo_attainments');
    }
};
