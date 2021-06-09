<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityItvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('itvs', function (Blueprint $table) {
	    $table->id();
	    $table->string('report_number')->comment('Nro de Informes  ejemplo: SFTT-ISTBJ-XX-VC-2020');
	    $table->integer('total_students')->comment('estudiantes que recibiran');
	    $table->integer('financing')->comment('financiamiento para el proyecto en $');
	    $table->string('object')->comment('objeto del ITV');
	    $table->json('institute_obligations');
	    $table->json('entity_obligations');
	    $table->foreignId('project_id')->constrained('community.projects');
	    $table->string('justification');
	    $table->text('conclusion');
	    $table->text('recommendation');
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
        Schema::connection('pgsql-community')->dropIfExists('itvs');
    }
}
