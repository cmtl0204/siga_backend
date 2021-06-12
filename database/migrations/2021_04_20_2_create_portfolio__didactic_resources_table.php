<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioDidacticResourcesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('didactic_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')
                ->comment('fk de tabla pea');
            $table->foreignId('type_id')->constrained('app.catalogues')
                ->comment('fk de la tabla catalogo del esquema app posibles valores (MATERIALES CONVENCIONALES,NUEVAS TECNOLOGÍAS)');
            $table->json('resources')->comment('Guarda los recursos didácticos');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('didactic_resources');
    }
}
