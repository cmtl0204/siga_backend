<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityPortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('portfolios', function (Blueprint $table) {
	    $table->id();
	    $table->foreignId('student_id')->nullable()->constrained('authentication.users')->comment('fk de la tabla user , si es nulo es un documento del proyecto');
	    $table->foreignId('user_id')->nullable()->constrained('authentication.users')->comment('persona que carga el documento (estudiante,docente)');
	    $table->foreignId('project_id')->nullable()->constrained('community.projects')->comment('fk tabla proyecto');
	    $table->foreignId('document_type')->nullable()->constrained('app.catalogues')->comment('fk de catalogo, con los nombre de los  9 que conforman el portafolio');
	    $table->foreignId('status_id')->nullable()->constrained('app.catalogues')->comment('fk catalogo de los estado de cada documento del portafolio aprobado o rechazado');
        $table->date('send_date')->format('d-m-Y')->comment('fecha de envio del documento');
	    $table->date('approval_date')->format('d-m-Y')->comment('fecha de aprobación  del documento');
	    $table->json('observations')->comment('observaciones del documento');
        $table->string('approved_by') >comment('persona que aprueba  el documento tutor,coordinador');

	    
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
        Schema::connection('pgsql-community')->dropIfExists('portfolios');
    }
}
