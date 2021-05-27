<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthShortcutsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('shortcuts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('authentication.users');

            $table->foreignId('role_id')
                ->constrained('authentication.roles')
                ->comment('Solo aparecen en el rol correspondiente');

            $table->foreignId('permission_id')
                ->constrained('authentication.permissions')
                ->comment('Para poder dar integridad y acceder a la ruta');

            $table->string('name');

            $table->text('description')
                ->nullable();

            $table->string('image');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('shortcuts');
    }
}
