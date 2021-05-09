<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthRolesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('system_id')
                ->constrained('authentication.systems')
                ->comment('Para que el rol pertenezca a un sistema');

            $table->foreignId('institution_id')
                ->nullable()
                ->constrained('app.institutions');

            $table->string('code')
                ->comment('No debe ser modificado una vez que se lo crea');

            $table->text('name');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('roles');
    }
}
