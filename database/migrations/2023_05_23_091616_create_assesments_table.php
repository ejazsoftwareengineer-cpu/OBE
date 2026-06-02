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
        Schema::create('assesments', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable(); 
            $table->string('short_name',50)->nullable(); 
           $table->integer('status')->default('0')->nullable();
            $table->integer('allowed_operation')->nullable();
            $table->integer('is_rubric')->nullable();
            $table->integer('allow_change_cms')->nullable();
            $table->text('cms_value')->nullable();
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
        Schema::dropIfExists('assesments');
    }
};
