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
        Schema::create('cqis', function (Blueprint $table) {
            $table->id();
            $table->integer('courseoffer_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('clo_id')->nullable();
            $table->text('cqiremarks')->nullable();
            $table->string('issue_date',200)->nullable();
            $table->string('name',210)->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('cqis');
    }
};
