<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalEvaluationablesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('evaluationables', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->integer("detail_evaluations_id");
            $table->integer("evaluationables_id");
            $table->integer("evaluationables_type");

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('evaluationables');
    }
}
