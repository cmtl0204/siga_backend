<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->comment('Codigo del fk de proyecto');
            $table->text('title', 500)->nullable()->comment('nombre o titulo  del proyecto');
            $table->foreignId('entity_id')->nullable()->comment('FK entidad beneficiaria')->constrained('entities');                 
            $table->foreignId('school_period_id')->nullable()->comment('Fk de periodos escolares')->constrained('app.school_periods'); // pgsql-ignug
            $table->foreignId('career_id')->nullable()->comment('fk de tabla de carreras')->constrained('app.careers');
            $table->date('date')->nullable()->comment('Fecha del proyecto');
            $table->json('cycles')->nullable()->comment('ciclo en json');
            $table->foreignId('coverage_id')->nullable()->comment('Catalogo de coberturas (nacional, provincial, cantonal)')->constrained('app.catalogues');
            $table->foreignId('location_id')->nullable()->comment('fk de localizacion/ubicacion')->constrained('app.locations');
            $table->integer('lead_time')->nullable()->comment('Plazo de ejecucion del proyecto en meses');
            $table->date('delivery_date')->nullable()->comment('Fecha de presentacion del proyecto'); // tiempo
            $table->date('start_date')->nullable()->comment('Fecha de inicio del proyecto'); // tiempo
            $table->date('end_date')->nullable()->comment('Fecha de culminacion del proyecto'); // tiempo
            $table->foreignId('frequency_id')->nullable()->comment('Frecuencia de actividades del proyecto (diaria, semanal, mensual, trimestral)')->constrained('app.catalogues');
            $table->text('description', 1000)->nullable()->comment('DESCRIPCION GENERAL  DEL PROYECTO.');
            $table->text('diagnosis', 300)->nullable()->comment('ANALISIS SITUACIONAL (DIAGNOSTICO)');
            $table->text('justification')->nullable()->comment('justificacion del proyecto');
            $table->json('direct_beneficiaries')->nullable()->comment('json del beneficiario directo del proyecto');
            $table->json('indirect_beneficiaries')->nullable()->comment('json del beneficiario indirecto del proyecto');
            $table->json('strategies')->nullable()->comment('Json de las estrategias');
            $table->json('bibliografies')->nullable()->comment('bibliografia del proyecto'); // pendiente
            $table->foreignId('status_id')->nullable()->comment('fk catalogo: estados del proyecto proceso, proceso de firma, por enviar a la senescyt, enviado a la senescyt, aprobado, rechazado, iniciado, en ejecución, terminado, por entregar certificados')->constrained('app.catalogues'); // catalogo propio una fk
            $table->json('observations')->nullable()->comment('Json de observaciones');
            $table->json('send_quipux')->nullable()->comment('json: quipux de envio y fecha');
            $table->json('receive_quipux')->nullable()->comment('json: quipux con que responde la senescyt y la fecha en que se recibe');
            $table->boolean('state')->default(true);
            $table->foreignId('created_by_id')->nullable()->comment('creado por fk')->constrained('authentication.users');
            $table->softDeletes();
            $table->timestamps();
            // $table->string('field',100)->nullable(); // campo de area de vinculacion
            // $table->text('introduction')->nullable();
            // $table->text('foundamentation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
