<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignId('detail_planification_id')->constrained('cecy.detail_planifications')
                  ->comment('se relaciona con la tabla detalle planificación ya que alli esta el detalle de aula,horario,etc');
            $table->foreignId('status_id')->constrained('app.status')
                   ->comment('Estado de la matricula (retirado, inscrito, matriculado etc)');

            // modulo de notas, hay que analizar como se va a llevar las notas y la parte academica
            $table->decimal('partial_grade', 5, 2)
                   ->comment('nota de evaluación continua');
            $table->decimal('final exam', 5, 2)
                    ->comment('nota del proyecto final');

            //Modulo de Certificado
            $table->string('certificate_code')->nullable()
                    ->comment('Codigo del certificado de los participnates');
            $table->foreignId('certificate_status_id')->constrained('app.status')
                    ->comment('estado del certificado, generado, firmado, por firmar');
            $table->date('certificate_retired_date')
                    ->comment('fecha de retiro certificado');
            $table->json('observations')
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
