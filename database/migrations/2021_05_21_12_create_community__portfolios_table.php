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
	    $table->foreignId('project_id')->constrained('community.projects');
	    $table->foreignId('document_type')->constrained('app.catalogues');
	    $table->date('send_date')->format('d-m-Y')->comment('fecha de envio del documento');
	    $table->date('approval_date')->format('d-m-Y')->comment('fecha de aprobación  del documento');
	    $table->string('ruc');
	    $table->string('name')->comment('Nombre de institución');
	    $table->json('observations');
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
