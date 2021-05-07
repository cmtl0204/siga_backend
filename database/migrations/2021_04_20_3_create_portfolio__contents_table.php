<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('portfolio.units')
                   ->comment('fk de tabla unidades');
            $table->integer ('week')
                 ->comment('Guarda el nro. de semana');
            $table->json ('contents')->nullable()
                 ->comment('tipo json, en una semana se puede dictar varios contenidos');
            $table->integer ('teaching_hours')->nullable()
                 ->comment('Guarda las horas docencia');
            $table->json ('teaching_activities')->nullable()
                  ->comment('tipo json, guarda las actividades docencia');
            $table->integer ('practical_hours')->nullable()
                  ->comment('Guarda las horas prácticas');
            $table->json ('practical_activities')->nullable()
                  ->comment('Guarda las actividades practicas');
            $table->integer ('autonomous_hours')->nullable()
                  ->comment('Guarda las horas autónomas');
            $table->json ('autonomous_activities')->nullable()
                  ->comment('Guarda las actividades autonomas');
            $table->json ('observations')->nullable()
                  ->comment('tipo json, guarda las observaciones');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('contents');
    }
}
