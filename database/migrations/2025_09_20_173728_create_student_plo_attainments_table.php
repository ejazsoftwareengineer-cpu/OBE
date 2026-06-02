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
        Schema::create('student_plo_attainments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('plo_id');
            $table->unsignedBigInteger('clo_id')->nullable(); // optional, in case you want to track CLO link
            $table->unsignedBigInteger('courseoffer_id');
            $table->decimal('weighted_total', 8, 2)->default(0.00);
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
        Schema::dropIfExists('student_plo_attainments');
    }
};
