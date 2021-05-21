<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityAgreementClausesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 
    public function up()
    {
        Schema::connection('pgsql-community')->create('agreement_clauses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->comment('FK de convenios')->connstrained('community.agreement');			
            $table->string('order')->nullable()->comment('orden en el que se imprime las clausulas ');
			$table->string('clause_name')->nullable()->comment('nombre del encabezado de la clausula.'); //Guarda el nombre del encabezado de la clausula.
			$table->text('description')->nullable()->comment('contenido de la clusula del convenio.'); // texto que describe la clausula del convenio.
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
        Schema::dropIfExists('agreement_clauses');
    }
}