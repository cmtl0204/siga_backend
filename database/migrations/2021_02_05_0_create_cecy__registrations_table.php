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
        Schema::connection('pgsql-cecy')->create('registrations', function (Blueprint $table) {
            $table->id();
            $table->date('date')
                   ->comment('fecha_matricula');
            $table->foreignId('participant_id')->constrained('cecy.participants')
                  ->comment('Participante a ser matriculados');
            $table->foreignId('status_id')->constrained('app.status')
                  ->comment('Estado de la matricula (inscrito, matriculado, anulado, desertor)');
            $table->foreignId('type_id')->nullable()->constrained('app.catalogues')
                  ->comment('tipo_matricula, ordinaria,extraordinaria,especial');
            $table->string('number')->comment('numero de folio de la matricula');
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
