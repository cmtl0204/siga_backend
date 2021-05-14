<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalPairResultsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('pair_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('answer_question_id')->comment('Pregunta y respuesta')->constrained('answer_question');
            $table->foreignId('detail_evaluation_id')->comment('Detalle Evaluacion Realizada');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('pair_results');
    }
}
