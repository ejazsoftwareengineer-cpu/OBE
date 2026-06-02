<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_clo_attainments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('clo_id');
            $table->unsignedBigInteger('courseoffer_id');
            $table->decimal('weighted_total', 8, 2)->default(0);
            $table->enum('achieved_flag', ['Y', 'N'])->default('N');
            $table->timestamps();

            $table->unique(['student_id', 'clo_id', 'courseoffer_id'], 'uq_student_clo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_clo_attainments');
    }
};
