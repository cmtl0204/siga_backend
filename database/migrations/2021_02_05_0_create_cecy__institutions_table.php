<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //periodo_lectivo
        Schema::connection('pgsql-cecy')->create('institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('app.institutions')->nullable()
                  ->comment('fk de la tabla institución');
            $table->foreignId('authority_id')
                  ->constrained("authorities")->comment('Maxima autoridad de la institucion (rector), quien firma un convenio, etc');
            $table->string('ruc')->nullable()->comment('Ruc de la institución');
            $table->string('logo')->nullable()->comment('logo de la institución');
            $table->string('name')->comment('nombre de la institución');
            $table->string('slogan')->nullable()->comment('solgan  de la institución');
            $table->string('code')->nullable()->comment('codigo de la institución');
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
        Schema::connection('pgsql-cecy')->dropIfExists('cecy_institutions');
    }
}
