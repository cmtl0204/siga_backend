<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('entities', function (Blueprint $table) {
	    $table->id();
	    $table->string('logo');
	    $table->string('ruc');
	    $table->string('name')->comment('Nombre de institución');
	    $table->string('short_name');
	    $table->foreignId('economic_activity_id')->constrained('app.catalogues');
	    $table->foreignId('nature_id')->constrained('app.catalogues')->comment('naturaleza de la fundación, fk de catalogo, public o privada');
	    $table->string('mail')->comment('correo de la entidad beneficiaria');
	    $table->string('permanent_phone');
	    $table->string('movil_phone');
	    $table->string('document_main')->comment('num del doc q le nombran representante legal: ');
	    $table->string('document_secondary')->comment('copia ci, de ruc etc');
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
        Schema::connection('pgsql-community')->dropIfExists('entities');
    }
}
