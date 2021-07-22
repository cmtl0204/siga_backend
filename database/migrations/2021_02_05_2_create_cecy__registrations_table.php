<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //matriculas
        Schema::connection('pgsql-cecy')->create('registrations', function (Blueprint $table) {
            $table->id();
            $table->date('date_registration')
                   ->comment('fecha_matricula'); 
            $table->foreignId('participant_id')->constrained('cecy.participants')
                  ->comment('Estudiantes a ser matriculados reistra el id_persona_participante'); 
            //$table->foreignId('participant_id')->constrained('cecy.participants')
                  //->comment('Estudiantes a ser matriculados reistra el id_persona_participante'); 
            $table->foreignId('status_id')->constrained('app.catalogues')
                  ->comment('Estado de la matricula (inscrito, matriculado, anulado, desertor)'); 
            $table->foreignId('type_id')->constrained('app.catalogues')
                  ->comment('tipo_matricula, ordinaria,extraordinaria,especial'); 
            $table->string('number')->comment('numero de folio de la matricula'); 
            $table->foreignId('planification_id')->constrained('cecy.detail_planifications')
                  ->comment('cada maticula esta relacionada a un detalle de la planificación del curso'); 
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
        Schema::connection('pgsql-cecy')->dropIfExists('registrations');
    }
}
