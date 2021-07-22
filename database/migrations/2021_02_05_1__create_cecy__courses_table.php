<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->comment('codigo único de un curso');
            $table->string('name')->comment('nombre del un curso, es asignado por el coodinar de carrera,campo obligatoria al momento de crear el curso');
            $table->integer('hours_duration')->comment('tiempo en horas que durará el curso, por ejemplo 40 horas, campo obligatoria al momento de crear el curso');
            $table->boolean('free')->nullable()->comment('True si el curso es gratis, false si el curso tiene un costo');
            $table->double('cost')->nullable()->comment('En caso que el curso es pagado, se debe especificar el valor');
           // $table->string('photo')->nullable()->comment('un curso debe registrase una foto esta foto se guarda en otra tabla');
            $table->string('summary')->nullable()->comment('Resumen del curso');
            $table->foreignId('modality_id')->nullable()->constrained('app.catalogues')->comment('Modalidad del curso, si es Virtual,presencial, hibridas, etc, campo foraneo de la tabla catalogo');
            $table->string('observation')->nullable()->comment('Se escribe observaciones del curso en caso de tener');
            $table->string('objective')->nullable()->comment('Guarda el Objetivo del Curso');
            $table->json('needs')->nullable()->comment('necesidades del curso es un array');
            $table->json('Target_group')->nullable()->comment('Grupo a cual va diriguido el curso');
            $table->json('facilities')->nullable()->comment('instalaciones  entorno de aprendizaje');
            $table->json('theoretical_phase')->nullable()->comment('fase teorica entorno de aprendizaje');
            $table->json('practical_phase')->nullable()->comment('fase practica entorno de aprendizaje');
            $table->json('main_topics')->nullable()->comment('temas principales');
            $table->json('secondary_topics')->nullable()->comment('Temas secundarios o sub temas');
            $table->json('cross_cutting_topics')->nullable()->comment('temas trasversales');
            $table->json('bibliography')->nullable()->comment('bibliografias');
            $table->json('teaching_strategies')->nullable()->comment('estrategias de enseñanza - aprendizaje');
            $table->foreignId('participant_type_id')->nullable()->constrained('app.catalogues')->comment('id_tipo_participante');
            $table->foreignId('area_id')->constrained('app.catalogues')->nullable()->comment('id_area');
            $table->foreignId('level_id')->constrained('app.catalogues')->nullable()->comment('id_niveles');
            $table->string('required_installing_sources')->nullable()->comment('recursos_requeridos_instalacion');
            $table->integer('practice_hours')->nullable()->comment('horas_practicas');
            $table->integer('theory_hours')->nullable()->comment('horas_teoricas');
            $table->foreignId('canton_dictate_id')->constrained('app.catalogues')->nullable()->comment('canton donde se dicta el curso');
            $table->foreignId('capacitation_type_id')->constrained('app.catalogues')->nullable()->comment('Se refiere a si la capacitacion es tipo curso, taller o webinar');
            $table->foreignId('course_type_id')->constrained('app.catalogues')->nullable()->comment('fk de catalogo guarda el id_tipo_curso posibles valores Setec o Senescyt');

            $table->foreignId('entity_certification_type_id')->constrained('app.catalogues')->nullable()->comment('Se refiere a la entidad que imparte el curso (SENESCYT, SETEC)');
            $table->string('practice_required_resources')->nullable()->comment('recursos_requeridos_practica');
            $table->string('aimtheory_required_resources')->nullable()->comment('recursos_requeridos_teoricos');
            $table->string('learning_teaching_strategy')->nullable()->comment('estrategias_enseñanza_aprendizaje');
            $table->foreignId('person_proposal_id')->constrained('authentication.users')->nullable()->comment('id_persona_propuesta');
            $table->date('proposed_date')->nullable()->comment('fecha_propuesta');
            $table->date('approval_date')->nullable()->comment('fecha_aprobacion curso');
            //$table->date('need_date')->comment('fecha_registro de necesidad');
            $table->string('local_proposal')->nullable()->comment('local_propuesta_a_dictar');
            //$table->foreignId('schedules_id')->constrained('schedules')->nullable()->comment('id_horario_propuesta'); //id_horario_propuesta //tabla polimorfica
            $table->string('project')->nullable()->comment('proyecto_curso');
            $table->integer('capacity')->nullable()->comment('capacidad_curso');
            $table->foreignId('classroom_id')->constrained('app.classrooms')->nullable()->comment('id_aula');
            
            $table->foreignId('specialty_id')->constrained('app.catalogues')->nullable()->comment('fk de catalogo que guarda el id_especialidad posible valores Idioma, tecnología, pedagogia, etc');
            $table->foreignId('academic_period_id')->constrained('app.catalogues')->nullable()->comment('id_periodo_academico');
            $table->foreignId('institution_id')->constrained('app.institutions')->nullable()->comment('id_institución');
            $table->string('place')->nullable()->comment('lugar donde se dictara el curso');
            $table->foreignId('career_id')->nullable()->constrained('app.careers')->comment('Se refiere a la carrera que le corresponde al curso');
            $table->string('setec_name')->comment('nombre_setec');
            $table->string('abbreviation')->comment('abreviación del nombre del curso, esto es para la generación del certificado del curso');
            //$table->integer('attached')->comment('adjunto de la acta de aprovación del curso'); este campo va en  files
            $table->foreignId('certified_type_id')->constrained('app.catalogues')->nullable()->comment('Fk de catalogo, tipo de certificado de asistencia o aprobación');
            $table->json('bibliographys')->nullable()->comment('Bibliografia del curso');


            $table->integer('status')->nullable()->default(1)->comment('1:propuesto,2:cuando es completado por el docente encargado, 3: dado de baja (cuando esta vencido la fecha de vigencia o cuando no fue aprovado por el OCS)');
            $table->timestamps();
            $table->softDeletes();
/*                    
                   
            $table->json('lista_prerequisitos')->nullable();           
            $table->json('lista_requisitos')->nullable();
            $table->json('lista_temas_principales')->nullable();
            $table->json'lista_temas_secundarios')->nullable();
            $table->json('lista_temas_transversales')->nullable();
            $table->json('lista_evaluaciones_diagnosticas')->nullable();
            $table->json('lista_evaluaciones_procesos')->nullable();
            $table->json('lista_evaluaciones_finales')->nullable();            
            $table->json('lista_instalaciones')->nullable();
            $table->json('lista_fases_teoricas')->nullable();
            $table->json('lista_fases_practicas')->nullable();       
          //$table->json('state')->nullable()->default(1)//borrar en todas las migraciones
  ;*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('pgsql-cecy')->dropIfExists('courses');
    }
}
