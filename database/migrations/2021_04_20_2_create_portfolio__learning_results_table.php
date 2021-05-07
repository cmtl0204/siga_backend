<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioLearningResultsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('learning_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')
                   ->comment('fk de tabla pea, un pea tiene varios resultados de aprendizaje ');
            $table->foreignId('parent_id')->constrained('portfolio.learning_results')
                   ->comment('campo que hace la recursividad, apunta al id de esta tabla');
            $table->string('code')->required()
                  ->comment('guada los valores 1, 1.1, 1.1.1 ......etc, este campo no debe permitir nulo y mediante programación se deben auto generar');
            $table->text('description')
                  ->comment('texto de la unidad de competencia, elemento de competencio, resultados de aprendizaje o forma de evidenciar');
            $table->foreignId('type_id')->constrained('app.catalogues')
                   ->comment('fk de la tabla catalogues, los valores son: UNIDADES DE COMPETENCIA / PROCESOS, ELEMENTOS DE COMPETENCIA / SUB-PROCESOS,RESULTADOS DE APRENDIZAJE /ACTIVIDADES o FORMAS DE EVIDENCIAR A LOS R.D.A.');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('learning_results');
    }
}
