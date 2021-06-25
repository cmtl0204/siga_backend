<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAuthoritiesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::connection('pgsql-cecy')->create('authorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('authentication.users')->comment('usuario clave foreanea de Authentication.user ');
            $table->foreignId('position_id')->constrained('app.catalogues')->comment('cargo en el cecy, datos como especialista,responsable de cecy,logistica');
            $table->foreignId('status_id')->nullable()->constrained('app.catalogues')->comment('datos como suspendio o retirado de catologue');
            $table->json('functions')->nullable()->comment('Funciones que tiene dentro del Cecy');
            $table->date('start_date')->nullable()->comment('Fecha inicio de la gestión');
            $table->date('end_date')->nullable()->comment('Fecha fin de la gestión');
            $table->softDeletes();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::connection('pgsql-cecy')->dropIfExists('authorities');
    }
}
