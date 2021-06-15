<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeaTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('pea_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pea_id')->constrained('portfolio.peas')
                   ->comment('fk de tabla pea');
                   $table->foreignId('teacher_id')->constrained('app.teachers')
                  ->comment('fk de profesores');
                   $table->foreignId('jornada_id')->constrained('app.catalogues')
                   ->comment('fk de la tabla catálogos');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('pea_teachers');
    }
}
