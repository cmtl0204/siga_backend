<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalSelfResultsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('self_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_question_id')->comment('Pregunta y Respuesta')->constrained('answer_question');
            $table->foreignId('teacher_id')->comment('Informacion Profesor a Calificar')->constrained('app.teachers');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('self_results');
    }
}
