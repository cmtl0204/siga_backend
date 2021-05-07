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
            $table->foreignId('learning_result_id')->constrained('portfolio.learning_results')
                ->comment('FK de la tabla learning_results (resultados de a_rendizaje)');
            //tabla career no esta creada se direccina al ignug
            $table->foreignId('learning_result_career_id')->constrained('app.career_learning_results')
                ->comment('FK de la tabla learning_results_career (resultados de a_rendizaje de la carrera)');
            $table->foreignId('contribution_id')->constrained('app.catalogues')
                ->comment('fk de catalogo y posibles valoires (medio, alta,bajo)');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('relation_learning_results');
    }
}
