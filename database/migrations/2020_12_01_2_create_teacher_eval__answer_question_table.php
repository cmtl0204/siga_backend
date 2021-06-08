<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalAnswerQuestionTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('answer_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_id')->comment('Relacion Respuesta')->schema('pgsql-teacher-eval');
            $table->foreignId('question_id')->comment('Relacion Pregunta')->schema('pgsql-teacher-eval');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('answer_question');
    }
}
