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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable(); 
            $table->string('roll_no',50)->nullable(); 
            $table->string('registration_no',50)->nullable();
            $table->string('email')->nullable();
            $table->string('nationality',30)->nullable();
            $table->string('state',30)->nullable();
            $table->string('city',30)->nullable();
            $table->string('marital_status',30)->nullable();
            $table->string('cnic',150)->nullable();
            $table->string('religion',30)->nullable();
            $table->string('admission_type',30)->nullable();
            $table->string('birthday',30)->nullable();
            $table->string('gender',10)->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number',25)->nullable();
            // inter
            $table->string('inter_degree_type',25)->nullable();
            $table->string('inter_max',25)->nullable();
            $table->string('inter_obt',25)->nullable();
            $table->string('passing_year_int',25)->nullable();
            $table->string('inter_board',25)->nullable();
            // matric
            $table->string('matric_degree_type',50)->nullable();
            $table->string('matric_passing_year',50)->nullable();
            $table->string('matric_max',50)->nullable();
            $table->string('matric_obt',50)->nullable();
            $table->string('matric_board',50)->nullable();
            // end matric
            $table->string('transfered',50)->nullable();
            $table->string('guardian',50)->nullable();
            $table->string('guardian_name',150)->nullable();
            $table->string('guardian_cnic',150)->nullable();
            $table->string('guardian_mobile',100)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('program_id')->nullable();  
            $table->integer('active_session_id')->nullable();  
            $table->string('student_profile_pic')->nullable();  
            $table->integer('status')->default('1')->nullable();
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
        Schema::dropIfExists('students');
    }
};
