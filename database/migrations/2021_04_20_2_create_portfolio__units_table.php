<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioUnitsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')
                   ->comment('fk de tabla pea');
            $table->string('description')
                   ->comment('texto del nombre de la unidad');
            $table->integer('order')
                    ->comment('Guarda el orden de la unidad (1, 2, 3, ...)');
            $table->string('name')
                     ->comment('tipo texto que guarda (Contenidos de la Unidad 1, Contenidos de la Unidad 2,.....)');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('units');
    }
}
