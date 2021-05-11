<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthModulesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('modules', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD:database/migrations/2020_06_21_2_create_auth__modules_table.php
            $table->foreignId('system_id')->constrained('authentication.systems')->comment('Para categorizar los modulos');
            $table->foreignId('status_id')->constrained('app.catalogues');
            $table->string('code')->comment('No debe ser modificado una vez que se lo crea');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('Icono de la libreria que se usa en el frontend');
=======

            $table->string('system_id')
                ->constrained('authentication.systems')
                ->comment('Para categorizar los modulos');

            $table->foreignId('status_id')
                ->constrained('app.catalogues');

            $table->string('code')
                ->comment('No debe ser modificado una vez que se lo crea');

            $table->string('name');

            $table->text('description')
                ->nullable();

            $table->string('icon')
                ->nullable()
                ->comment('Icono de la libreria que se usa en el frontend');

>>>>>>> mod_3_authentication:database/migrations/2020_06_21_1_create_auth__modules_table.php
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('modules');
    }
}
