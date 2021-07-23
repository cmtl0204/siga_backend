<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalResearchsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('researchs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->comment('Informacion Profesor')->constrained('app.teachers');
            $table->double('inv_auto_eval')->nullable()->comment('Investigacion Auto-Evaluacion');
            $table->double('inv_pares')->nullable()->comment('Investigación - Pares');
            $table->double('inv_coodinador')->nullable()->comment('Investig - Coodinador');
            $table->double('total')->nullable()->comment('Total Investigacion');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('pair_results');
    }
}
