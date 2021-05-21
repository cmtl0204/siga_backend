<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('assistances', function (Blueprint $table) {
	    $table->id();
	    $table->foreignId('student_id')->nullable()->constrained('authentication.users')->comment('fk de la tabla user , si es nulo es un documento del proyecto');
	    $table->foreignId('project_id')->constrained('community.projects');
	    $table->date('date')->format('d-m-Y')->comment('fecha de la actividad');
	    $table->time('start_time')->comment('hora inicio');
	    $table->time('end_time')->comment('hora fin');
	    $table->text('activities');
	    $table->string('reviewed_by')->comment('tutuor que revisa  el cumplimiento actividades y el tiempo');
	    $table->json('observations')->comment('json, observaciones de cada actividad (estas observaciones no se imprime)');
	    $table->foreignId('status_id')->constrained('app.catalogues')->comment('estado de revizado o rechazado (cuando hay oservaciones)');
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
        Schema::connection('pgsql-community')->dropIfExists('assistances');
    }
}
