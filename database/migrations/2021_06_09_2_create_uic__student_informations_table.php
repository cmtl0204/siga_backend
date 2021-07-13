<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicStudentInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('student_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('app.students');
            $table->string('company_work')->nullable()->comment('empresa donde labora');
            $table->foreignId('relation_laboral_career_id')->constrained('app.catalogues')->nullable();
            $table->foreignId('company_area_id')->constrained('app.catalogues')->nullable()->comment('area en la empresa');
            $table->foreignId('company_position_id')->constrained('app.catalogues')->nullable()->comment('posición que ocupa en la empresa');
            $table->softDeletes();
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
        Schema::connection('pgsql-uic')->dropIfExists('mesh_student_requirements');
    }
}
