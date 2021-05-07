<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioPeasTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-portfolio')->create('peas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('app.subjects')
                  ->comment('fk de asignatura');
            $table->foreignId('school_period_id')->constrained('app.school_periods')
                  ->comment('fk de periodo lectivo');
            $table->string('student_assessment')
                  ->comment('Foto de Evaluación del Estudiante, guarda la ruta de la imagen');
            $table->json('basic_bibliographies')
                  ->comment('Bibliografía básica');
            $table->json('complementary_bibliographies')
                  ->comment('Bibliografía complementaria');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-portfolio')->dropIfExists('peas');
    }
}
