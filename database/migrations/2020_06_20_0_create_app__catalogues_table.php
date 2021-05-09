<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppCataloguesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('catalogues', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')
                ->nullable()
                ->comment('Un catalogo puede tener catalogos hijos')->constrained('app.catalogues');

            $table->string('code')
                ->comment('No debe ser modificado una vez que se lo crea');

            $table->text('name');

            $table->text('description')
                ->nullable();

            $table->text('color')
                ->comment('color en hexadecimal')->default('#9c9c9c');

            $table->string('type')
                ->comment('Para categorizar los catalogos');

            $table->string('icon')
                ->nullable()
                ->comment('Icono de la libreria que se usa en el frontend');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('catalogues');
    }
}
