<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyPlanificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('planifications', function (Blueprint $table) {
            $table->id();
            $table->date('date_start')->comment('guarda la fecha inicio del curso');
            $table->date('date_end')->comment('guarda la fecha fin del curso');
            $table->foreignId('course_id')->constrained('courses')->comment('FK de la tabla curso');
            $table->json('needs')->comment('Existe casos que el curso existe sin embargo al momento de impartirlo nuevamente las becesidades cambien, esto se registra en la lanificación, por defecto debe mostrar las registrada en el curso, con opción a ser cambiada');
            $table->foreignId('teacher_responsable_id')->constrained('authentication.users')->comment('docente encargado de realizar toda la planificación del cecy, crear su equipo de docentes a impartir el curso, entregar notas, asistencia, etc'); //responsable_id
            //$table->foreignId('school_period_id')->constrained('ignug.school_periods')->nullable(); //school_period_id
            $table->foreignId('status_id')->constrained('app.catalogues')->comment('Una planifición puede ser dada de baja(cuando fue propuesta por el coodinador pero no se ejecuto), en ejecución o completada(entrego notas y el resto de documentación)');
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
        Schema::dropIfExists('planifications');
    }
}