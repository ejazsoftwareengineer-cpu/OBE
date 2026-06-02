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
        Schema::create('plo', function (Blueprint $table) {
            $table->id();
            $table->string('code',100)->nullable();
            $table->string('name',100)->nullable();
            $table->text('description')->nullable();
            $table->text('strategies')->nullable();
            $table->string('knowledge_profile',100)->nullable();
            // $table->string('wa_code',100)->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('program_id')->nullable();
            $table->integer('institute_id')->nullable();
            $table->integer('peo_id')->nullable();
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
        Schema::dropIfExists('plo');
    }
};
