<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthRoutesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('routes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')->nullable()
                ->constrained('authentication.routes')
                ->comment('Una ruta puede tener rutas hijas');

            $table->foreignId('module_id')
                ->constrained('authentication.modules')
                ->comment('Cada ruta debe pertenecer a un modulo del sistema');

            $table->foreignId('type_id')
                ->constrained('app.catalogues')
                ->comment('Tipo de ruta: megamenu, menu normal');

            $table->foreignId('status_id')
                ->constrained('app.status')
                ->comment('Para saber si la ruta esta disponible o en mantenimiento');

            $table->string('uri')
                ->comment('La direccion de la ruta en el frontend');

            $table->string('name')
                ->comment('Nombre de la ruta');

            $table->text('description')
                ->comment('Descripcion de la ruta');

            $table->string('icon')
                ->nullable()
                ->comment('Icono de la libreria que se usa en el frontend');

            $table->string('logo');

            $table->integer('order')
                ->comment('Orden que apareceran las rutas en la interfaz');

            $table->boolean('is_link')
                ->default(true)
                ->comment('Si la ruta es link o no');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('routes');
    }
}
