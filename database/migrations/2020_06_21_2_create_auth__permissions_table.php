<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthPermissionsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('route_id')
                ->constrained('authentication.routes')
                ->comment('Ruta a la que va a tener acceso el permiso');

            $table->foreignId('system_id')
                ->constrained('authentication.systems')
                ->comment('Para que el permiso pertenezca a un sistema');

            $table->foreignId('institution_id')
                ->nullable()
                ->constrained('app.institutions');

            $table->string('name');
            $table->text('description')->nullable();

            $table->json('actions')
                ->comment('[INDEX, STORE, UPDATE, DESTROY], etc');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('permissions');
    }
}
