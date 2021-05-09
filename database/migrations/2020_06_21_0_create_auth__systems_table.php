<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthSystemsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('systems', function (Blueprint $table) {
            $table->id();

            $table->string('code')
                ->comment('No debe ser modificado una vez creado');

            $table->string('name');

            $table->string('acronym');

            $table->text('description')
                ->nullable();

            $table->string('icon')
                ->nullable()
                ->comment('De la libreria que se usa en el frontend');

            $table->string('version')
                ->comment('XX.XX.XX');

            $table->string('redirect')
                ->comment('pagina web de redireccion del cliente');

            $table->date('date')
                ->comment('Fecha del sistema');

            $table->foreignId('status_id')
                ->constrained('app.catalogues');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('systems');
    }
}
