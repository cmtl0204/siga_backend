<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioSignaturesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')->comment('fk de tabla pea');
            $table->foreignId('user_id')->constrained('authentication.users')->comment('fk de user, representa la persona que firma');
            $table->foreignId('type_id')->constrained('app.catalogues')->comment('fk de catalogo ( docente, coordinador de carrera)');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('signatures');
    }
}
