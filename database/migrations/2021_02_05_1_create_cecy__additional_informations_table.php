<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAdditionalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //convenios
        Schema::connection('pgsql-cecy')->create('additional_informations', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->comment('nombre de empresa'); 
            $table->string('company_activity')->comment('actividad de la empresa'); 
            $table->string('company_address')->comment('direccion fisica de empresa'); 
            $table->string('company_phone')->comment('correo electronico  de empresa');            
            $table->boolean('company_sponsor')->comment('la empresa patrocina ek curso (auspiciada)'); 
            $table->string('name_contact')->comment('nombre de contacnto q patrocina'); 
            $table->json('know_course')->comment('como se entero del curso? Array'); 
            $table->json('course_follow')->nullable()->comment('cursos que te gustaria seguir? Array'); 
            $table->boolean('works')->comment('el participante trabaja?'); 
            $table->foreignId('level_instruction')->constrained('app.catalogues')->comment('id_nivel de instruccion'); 
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
        Schema::connection('pgsql-cecy')->dropIfExists('additional_informations');
    }
}