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
<<<<<<< HEAD
            $table->foreignId('agreement_id')->nullable()->constrained('community.agreements')->comment('fk de la tabla convenios');
=======
            $table->foreignId('agreement_id')->nullable()->constrained('community.agreements')->comment('FK de convenios ');
>>>>>>> mod_5_community
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