<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityEntityPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('entity_persons', function (Blueprint $table) {
	    $table->id();
	    //$table->foreignId(column:'project_id')->constrained(table:'community.projects');
	    $table->foreignId('position_id')->constrained('app.positions') ->comment('cargo de la persona (repr legal entidad, contacto entidad, administrador entidad, administ insti, autorizado a firmar convenios, tutor empresa, coordinador insti, tutor insti,Estudiante,rector');
	    $table->string('lastname')->nullable();
	    $table->string('name');
	    $table->string('mail');
	    $table->string('permanent_phone');
	    $table->string('movil_phone');
	    $table->string('function')->comment('funcion que cumple esta persona dentro del proyecto de la entidad ');
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
        Schema::connection('pgsql-community')->dropIfExists('entity_persons');
    }
}
