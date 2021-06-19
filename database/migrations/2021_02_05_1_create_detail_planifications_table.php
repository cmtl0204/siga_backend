<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPlanificationsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('detail_planifications', function (Blueprint $table) {
            $table->id();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('summary',1000); //resumen
            $table->date('planned_end_date'); //fecha fin prevista
            $table->foreignId('course_id')->constrained('courses');//cursos_id
            $table->foreignId('instructor_id')->constrained('instructors');


            $table->foreignId('authority_rector')->constrained('authorities')->comment('rector o autoridad principal que firma el certificado'); 
            $table->foreignId('authority_participants_firm')->constrained('authorities')->comment('Autoridad que firma el certificado de los participnates despues del rector'); 
            $table->foreignId('authority_instructor_firm')->constrained('authorities')->comment('Autoridad que firma el diploma de los instructores despues del rector'); 
            $table->string('location_certificate',900)->nullable()->comment('ubicacion del diploma del instructor dentro del servidor');
            $table->string('code_certificate',200)->nullable()->comment('codigo del diploma del instructor'); 
            $table->foreignId('status_certificate_id')->constrained('app.catalogues')->comment('Estado del certificado'); //estado del certificado



            $table->foreignId('state_id')->constrained('app.status');//stado_id
            // $table->foreignId('status_id')->constrained('catalogues');//status de la planificacion
           //  $table->foreignId('schedule_id')->constrained('schedule');//horario polimorfica
            //$table->foreignId('school_period_id')->constrained('school_periods')->nullable();//periodo_id
            // $table->foreignId('classroom_id')->constrained('ignug.classrooms');//id_aula
            $table->integer('capacity'); //capacidad_curso

            $table->foreignId('site_dictate')->constrained('app.catalogues')->comment('lugar donde se dicta el curso');  //lugar donde se dicta

            $table->string('observation',1000); //observaciones
            $table->foreignId('conference')->constrained('app.catalogues'); //jornada
            // $table->foreignId('responsible_id')->constrained('authorities'); //id autoridad a cargo responsable
            $table->foreignId('parallel')->constrained('app.catalogues'); //jornada
            $table->json('needs'); //necesidades del curso es un array
            $table->date('need_date'); //fecha_registro de necesidad
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
        Schema::connection('pgsql-cecy')->dropIfExists('planifications');
    }
}
