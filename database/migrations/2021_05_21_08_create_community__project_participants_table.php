<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityProjectParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('project_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->comment('FK del proyecto asociado')->constrained();
            $table->foreignId('user_id')->nullable()->comment('FK users (Estudiante,docente,adminisrativo), cuando es rector se realiza un join con user_contrato y se extrae la información del contrato del rector')->constrained('authentication.users');
            $table->foreignId('type_id')->nullable()->comment('fk de catalogo, (coordinador, tutor, estudiante, rector, profesor)')->constrained('app.catalogues');
            $table->date('start_date')->nullable()->comment('Fecha de inicio del proyecto'); // tiempo
            $table->date('end_date')->nullable()->comment('Fecha de culminacion del proyecto'); // tiempo
            $table->string('schedule_job', 20)->nullable()->comment('horario de trabajo');
            $table->string('position')->nullable()->comment('Posicion del participante');
            //$table->string('resolucion')->nullable();
            $table->integer('working_hours')->nullable()->comment('horas de trabajo');
            $table->json('functions')->nullable()->comment('json, funcion que cumple esta persona dentro del proyecto de la entidad (coordinador, tutor,desarrollador,diseñador,DBA)');
            $table->boolean('state')->default(true);
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
        Schema::dropIfExists('teacher_participants');
    }
}
