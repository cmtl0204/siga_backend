<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyDetailPlanificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('detail_planifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planification_id')->constrained('cecy.planifications');
            $table->integer('days')->nullable()->comment('Total de dias que se dicta el curso');
            $table->integer('day_hours')->nullable()->comment('total de horas que se dicta en el dia');
            $table->time('start_time')->nullable()->comment('Hora de entrada');
            $table->time('end_time')->nullable()->comment('hora de salida');
            $table->date('start_date')->comment('guarda la fecha inicio del curso');
            $table->date('planned_end_date')->comment('guarda la fecha planificada de fin del curso');
            $table->date('end_date')->comment('guarda la fecha real de fin del curso');
            $table->string('place')->nullable()->comment('lugar donde se va a dictar');
            $table->foreignId('schedule_id')->constrained('app.catalogues')->nullable()
                ->comment('L-V, S, D');
            $table->integer('capacity')->nullable()->comment('capacidad_curso');
            $table->foreignId('status_id')->constrained('app.status');
            $table->foreignId('parallel_id')->constrained('app.catalogues');
            $table->foreignId('status_certificate_id')->constrained('app.catalogues')->comment('Estado del certificado'); //estado del certificado
            $table->json('observations')->comment('por si llega a tener observaciones el curso')->nullable();
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
        Schema::connection('pgsql-cecy')->dropIfExists('detail_planifications');
    }
}
