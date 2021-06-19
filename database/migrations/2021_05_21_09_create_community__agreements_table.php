<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 
    public function up()
    {
        Schema::connection('pgsql-community')->create('agreements', function (Blueprint $table) {
            $table->id();
			$table->string('code')->nullable()->comment('Codigo del convenio.'); //codigo correspondiente al convenio, ejemplo VC-ISTBJ-2019-002
            $table->foreignId('itv_id')->nullable()->constrained('community.itvs')->comment('FK del itv ');
            $table->date('suscription_date')->nullable()->comment('Fecha de suscripcion del convenio'); //fecha correspondiente a la suscripcion del convenio.
		    $table->date('due_date')->nullable()->comment('Fecha en la que finaliza un convenio'); //indica la fecha en la que un convenio finaliza.
		    $table->integer('time')->nullable()->comment('Guarda el numero de meses de un convenio ');//el numero de meses del convenio
		    $table->string('accordance')->nullable()->comment('Numero y fecha del acuerdo para suscribir convenio.'); // guarda el numero y fecha del acuerdo para suscribir convenio, EjemploAcuerdo No. 2016-188 de 25 de julio de 2016.
			$table->json('clause_one')->nullable()->comment('json de los antecedentes.'); // se guarda un json de los antecedentes . 
			$table->json('clause_two')->nullable()->comment('json de los objetivos.'); //Se guardan un json de las objetivos.
			$table->json('clause_three')->nullable()->comment('json de las oblogaciones.'); //Se guarda un json de las obligaciones 
			$table->json('clause_four')->nullable()->comment('json de del o vigencio de un convenio.'); // se guarda un json de la vigencia o plazo de un convenio.
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
        Schema::dropIfExists('agreements');
    }
}
