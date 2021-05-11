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
            $table->string('code')->nullable()
                ->comment('codigo único de un curso');
            $table->string('abbreviation')->comment('abreviación del nombre del curso, esto es para la generación del certificado del curso');
            $table->string('name')
                ->comment('nombre del un curso, es asignado por el coodinar de carrera,campo obligatoria al momento de crear el curso');
            $table->integer('duration')
                ->comment('tiempo en horas que durará el curso, por ejemplo 40 horas, campo obligatoria al momento de crear el curso');
            $table->foreignId('institution_id')->constrained('cecy.institutions')->nullable()->comment('id_institución');
            $table->foreignId('anc_id')->constrained('app.catalogues')->nullable()
                ->comment('ALINEACIÓN AL EJE DE LA ANC (DISEÑO CURRICULAR)');
            $table->foreignId('type_id')->constrained('app.catalogues')->nullable()
                ->comment('fk de catalogo guarda el id_tipo_curso posibles valores Administrativo o Tecnico');
            $table->foreignId('modality_id')->nullable()->constrained('app.catalogues')
                ->comment('Modalidad del curso, si es Virtual,presencial, hibridas, etc, campo foraneo de la tabla catalogo');
            $table->text('summary')->nullable()->comment('Resumen del curso');
            $table->text('project')->nullable()->comment('Posible proyecto');
            $table->json('target_groups')->nullable()
                ->comment('tipo de participantes a cual va diriguido el curso (niños, jovenes, adultos etc');
            $table->json('participant_type')->nullable()
                ->comment('tipo de participantes para poder filtrar los cursos (estudiantes, docentes, externos)');
            $table->foreignId('specialty_id')->constrained('app.catalogues')->nullable()
                ->comment('fk de catalogo que guarda el id_especialidad posible valores Idioma, tecnología, pedagogia, etc');
            $table->json('technical_requirements')->nullable()
                ->comment('Requisitos minimos tecnicos para entrar al curso');
            $table->json('general_requirements')->nullable()
                ->comment('Requisitos minimos generales para entrar al curso');
            $table->string('objective')->nullable()->comment('Guarda el Objetivo del Curso');
            $table->json('cross_cutting_topics')->nullable()->comment('temas trasversales');
            $table->json('teaching_strategies')->nullable()->comment('estrategias de enseñanza - aprendizaje');
            $table->json('bibliographies')->nullable()->comment('bibliografias');
            $table->boolean('free')->nullable()
                ->comment('True si el curso es gratis, false si el curso tiene un costo');
            $table->double('cost')->nullable()
                ->comment('En caso que el curso es pagado, se debe especificar el valor');
            $table->json('observations')->nullable()->comment('Se escribe observaciones del curso en caso de tener');
            $table->foreignId('capacitation_type_id')->constrained('app.catalogues')->nullable()
                ->comment('Se refiere a si la capacitacion es tipo curso, taller o webinar');
            $table->foreignId('entity_certification_type_id')->constrained('app.catalogues')->nullable()
                ->comment('Se refiere a la entidad que imparte el curso (SENESCYT, SETEC)');
            $table->foreignId('certified_type_id')->constrained('app.catalogues')->nullable()
                ->comment('Fk de catalogo, tipo de certificado de asistencia o aprobación');

//            $table->string('aimtheory_required_resources')->nullable()->comment('recursos_requeridos_teoricos');
//            $table->string('practice_required_resources')->nullable()->comment('recursos_requeridos_practica');

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
        Schema::connection('pgsql-cecy')->dropIfExists('courses');
    }
}
