<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyEvaluationMechanismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //periodo_lectivo
        Schema::connection('pgsql-cecy')->create('evaluation_mechanisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained("app.status"); //id_estados
            //$table->foreignId('status_id')->constrained("catalogues"); //id_estatus
            $table->foreignId('type_id')->constrained('app.catalogues'); //evaluacion diagnostica, evaluacion proceso formativo y evaluacion final
            $table->string('technique',200); //tecnica
            $table->string('instrument',200); //instrumento
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
        Schema::connection('pgsql-cecy')->dropIfExists('evaluation_mechanisms');
    }
}