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
            $table->integer('days')->nullable()->comment('Total de dias que se dicta el curso para reporte de asistencia');
            $table->integer('day_hours')->nullable()->comment('total de horas que se dicta en el dia para reporte de asistencia');
            $table->foreignId('course_id')->constrained('cecy.courses')->comment('FK de la tabla curso');
            $table->foreignId('teacher_id')->constrained('authentication.users')
                ->comment('docente encargado (responsable) de realizar toda la planificación del cecy, crear su equipo de docentes a impartir el curso, entregar notas, asistencia, etc'); //responsable_id
            $table->foreignId('responsible_id')->comment('responsable del cecy en llevar el proceso')
                ->constrained('cecy.authorities');
            $table->foreignId('career_id')->nullable()->constrained('app.careers')->comment('Se refiere a la carrera que le corresponde al curso');
            $table->date('proposed_date')->comment('fecha propuesta por coordinador');
            $table->json('needs')
                ->comment('Existe casos que el curso existe sin embargo al momento de impartirlo nuevamente las necesidades cambien, esto se registra en la lanificación, por defecto debe mostrar las registrada en el curso, con opción a ser cambiada');
            $table->foreignId('school_period_id')->constrained('app.school_periods')->nullable();
            $table->foreignId('location_id')->constrained('app.locations')->nullable()->comment('parroquia donde se dicta el curso');
            $table->integer('practice_hours')->nullable()->comment('horas_practicas');
            $table->integer('theory_hours')->nullable()->comment('horas_teoricas');
            $table->foreignId('status_id')->constrained('app.catalogues')
                ->comment('Una planifición puede ser dada de baja(cuando fue propuesta por el coodinador pero no se ejecuto), en ejecución o completada(entrego notas y el resto de documentación)');
            $table->date('approval_date')->nullable()->comment('fecha_aprobacion_curso');
            $table->string('project')->nullable()->comment('El entregable del cruso');
            $table->json('installations')->nullable()
                ->comment('guarda el codigo del aula e indica si se va a utilizar en fase teorica o practica');
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
        Schema::dropIfExists('planifications');
    }
}