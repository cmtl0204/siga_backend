<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioMethodologicalStrategiesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('methodological_strategies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')
                ->comment('fk de tabla pea');
            $table->foreignId('strategy_id')->constrained('app.catalogues')
                ->comment('fk de la tabla catalogo del esquema app posibles valores (Técnicas expositivas: clases teóricas,Seminarios-talleres,Clases prácticas....)');
            $table->string('purpose')->comment('tipo String, guarda la finalidad de la estrategia');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('methodological_strategies');
    }
}
