<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalStudentResultsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('student_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_question_id')->comment('Pregunta y respuesta')->constrained('answer_question');
            $table->foreignId('subject_teacher_id')->comment('Asignatura Profesor')->constrained('app.subject_teacher');
            $table->foreignId('student_id')->comment('Informacion Estudiante Evaluador')->constrained('app.students');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('student_results');
    }
}
