<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioRelationLearningResultsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('relation_learning_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')
                   ->comment('fk de tabla pea');
            $table->foreignId('learning_result_id')->constrained('portfolio.learning_results')
                ->comment('FK de la tabla learning_results (resultados de aprendizaje)');

            $table->foreignId('contribution_id')->constrained('app.catalogues')
                ->comment('fk de catálogo y posibles valores (medio, alta,bajo)');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('relation_learning_results');
    }
}
