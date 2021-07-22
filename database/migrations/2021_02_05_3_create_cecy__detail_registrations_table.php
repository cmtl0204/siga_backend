<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\Models\App;
use app\Models\Cecy;

class CreateCecyDetailRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //detalle_matriculas
        Schema::connection('pgsql-cecy')->create('detail_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('cecy.registrations')
                   ->comment('FK de la tabla matricula'); 
            $table->foreignId('additional_information_id')->constrained('cecy.additional_informations')
                  ->comment('FK de la tabla additional_informations(información adicional), existen curso que son ausicioado por una entidad externa o son pagado por el particiante'); 
            $table->foreignId('detail_planification_id')->constrained('cecy.detail_planifications')
                  ->comment('se relaciona con la tabla detalle planificación ya que alli esta el detalle de aula,horario,etc'); 
            $table->foreignId('status_id')->constrained('app.catalogues')
                   ->comment('Estado de la matricula (retirado, aprobado,reprobado)'); 
            //modulo de notas
            $table->decimal('partial_grade1', 5, 2)
                   ->comment('nota parcial1'); 
                   
            $table->decimal('partial_grade2', 5, 2)
                    ->comment('nota parcial2');
                     
            $table->decimal('final_note', 5, 2)
                    ->comment('nota final del curso'); 
            //Modulo de Certificado
            $table->string('code_certificate')->nullable()
                    ->comment('Codigo del certificado de los participnates');
            $table->foreignId('status_certificate_id')->constrained('app.catalogues')
                    ->comment('estado del certificado, generado, firmado,por firmar'); 
            $table->string('certificate_withdrawn')
                    ->comment('fecha de retiro certificado'); 
            $table->string('location_certificate')->nullable()
                   ->comment('ubicacion del certificado del participante dentro del servidor');
            $table->json('observation')
                     ->comment('observacion del estudiante matriculado curso'); 
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
        Schema::connection('pgsql-cecy')->dropIfExists('detail_registrations');
    }
}
