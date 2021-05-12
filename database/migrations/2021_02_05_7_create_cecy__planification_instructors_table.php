<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyPlanificationInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //planificación_curso_instructores
        Schema::connection('pgsql-cecy')->create('planification_instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('instructors')->comment('id_persona_instructor');
            $table->foreignId('planification_id')->constrained('planifications')->comment('El docente responsable asigna su equipo de trabajo,una planificción puede tener muchos instructores');
//$table->foreignId('detail_registration_id')->constrained('detail_registrations')->comment('id_detalle_matricula');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('pgsql-cecy')->dropIfExists('planification_instructors');
    }
}
