<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalQuestionsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_type_id')->nullable()->comment('Tipo Evaluacion; Pares-Autoevaluacion-Coordinacion-Docente')
            ->constrained('teacher_eval.evaluation_types');
            $table->foreignId('type_id')->comment('Tipo Pregunta, Cuantitativa o Cualitativa')->constrained('app.catalogues');
            $table->foreignId('status_id')->constrained('app.status');
            $table->string('code')->comment('Codigo Pregunta');
            $table->integer('order')->comment('Orden Pregunta');
            $table->string('name')->comment('Pregunta');
            $table->text('description')->nullable()->comment('Descripcion Pregunta');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('questions');
    }
}
