<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicInformationStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('information_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('app.students');
            $table->string('province_birth');
            $table->string('canton_birth');
            $table->string('company_work')->nullable()->comment('empresa donde labora');
            $table->string('relation_laboral_career')->nullable()->comment('relacion laboral vs carrera');
            $table->string('area')->nullable()->comment('area en la empresa');
            $table->string('position')->nullable()->comment('posición que ocupa en la empresa');
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
