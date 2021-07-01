<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityCommunityRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community__community_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('authentication.users')->comment('FK de user'); // datos principales de estudiantes.		
            $table->date('date_request')->nullable()->comment('fecha que el estudiante realiza la solicitud. ');
			$table->string('status')->nullable()->comment('estado en la que se encuetra la solicitud.'); //Guarda el nombre del encabezado de la clausula.
			$table->text('observation')->nullable()->comment('contenido de la clusula del convenio.'); // texto que describe la clausula del convenio.
			$table->text('academic_period')->nullable()->comment('preriodo academico en el que hace la solicitud.'); 
			$table->text('nivel')->nullable()->comment('nivel que se encuentra el estudiante.'); 
			
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
        Schema::dropIfExists('community__community_requests');
    }
}
