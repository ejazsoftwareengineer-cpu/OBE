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
        Schema::create('sap_obe_data', function (Blueprint $table) {
            $table->id();
            $table->string('AdmAyear')->nullable();
            $table->string('AdmPerid')->nullable();
            $table->string('SapId')->nullable();
            $table->string('ProgNam')->nullable();
            $table->string('OrgId')->nullable();
            $table->string('OrgNam')->nullable();
            $table->string('InstId')->nullable();
            $table->string('Varyf')->nullable();
            $table->string('InstNam')->nullable();
            $table->string('ScObjid')->nullable();
            $table->string('AwObjid')->nullable();
            $table->string('Course')->nullable();
            $table->string('Cpattemp')->nullable();
            $table->string('Packnumber')->nullable();
            $table->string('SecNam')->nullable();
            $table->string('Tabnr')->nullable();
            $table->string('TeacherId')->nullable();
            $table->string('Teacher')->nullable();
            $table->string('StObjid')->nullable();
            $table->string('Student12')->nullable();
            $table->string('VornaMc')->nullable();
            $table->string('NachnMc')->nullable();
            $table->string('Student')->nullable();
            $table->string('Smstatus')->nullable();
            $table->string('Agrid')->nullable();
            $table->string('Agrtype')->nullable();
            $table->string('Agrremark')->nullable();
            $table->string('Sessional')->nullable();
            $table->string('Mid')->nullable();
            $table->string('Final')->nullable();
            $table->string('Performance')->nullable();
            $table->string('Viva')->nullable();
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
        Schema::dropIfExists('sap_obe_data');
    }
};
