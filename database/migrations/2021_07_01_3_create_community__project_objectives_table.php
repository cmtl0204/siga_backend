<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityProjectObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('project_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->comment('Fk del proyecto asociado')->constrained('community.projects');
            $table->foreignId('parent_id')->nullable()->comment('Fk del padre del registro, tabla recursiva')->constrained('project_objectives'); // tabla recusiva
            $table->string('code', 20)->nullable()->comment('1, 1.1,1.2 etc, es el codigo que identifica al objetivo');
            $table->foreignId('type_id')->nullable()->comment('(obj gral, obj espe, indicador, medio verif, actividad)')->constrained('app.catalogues'); // crear tipo de catologos
            $table->text('description')->nullable()->comment('narración del ojetivo del medio de verificación o actividad'); // linea base$table->text('indicator')->nullable();
            $table->json('verification_means')->nullable()->comment('1 medio de verif siempre tiene un indicador verificable');
            $table->boolean('state')->default(true);
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
        Schema::dropIfExists('objectives');
    }
}
