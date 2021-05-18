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
        Schema::connection('pgsql-cecy')->create('additional_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_registration_id')->constrained('cecy.detail_registrations');
            $table->foreignId('instruction_level_id')->comment('Nivel de instrucción del participante')
                ->constrained('app.catalogues');
            $table->string('company_name')->comment('nombre de empresa o donde estudia');
            $table->string('company_address')->comment('direccion fisica de empresa');
            $table->string('company_email')->comment('correo de la empresa');
            $table->string('company_phone')->comment('telefono de la empresa');
            $table->string('company_activity')->comment('actividad de la empresa');
            $table->boolean('is_company_sponsoring')->comment('la empresa patrocina ek curso (auspiciada)');
            $table->string('contact_name')->comment('nombre de contacto q patrocina');
            $table->json('know_course')->comment('como se entero del curso? Array (catalogo)');
            $table->json('courses')->nullable()->comment('cursos que te gustaria seguir? Array');
            $table->boolean('is_working')->comment('el participante trabaja?');
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
