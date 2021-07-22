<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalExtraCreditsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('extra_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->comment('Informacion Profesor')->constrained('app.teachers');
            $table->double('diploma_yavirac')->nullable()->comment('Diploma Yavirac');
            $table->double('title_fourth_level')->nullable()->comment('Titulo de cuarto nivel');
            $table->double('OCS_member')->nullable()->comment('Miembro de OCS');
            $table->double('governing_processes')->nullable()->comment('PROCESOS GOBERNANTES (coord. academica, coord, administrativa)');
            $table->double('process_nouns')->nullable()->comment('Procesos Sustantivos');
            $table->double('support_processes')->nullable()->comment('Procesos de Apoyo');
            $table->double('total')->nullable()->comment('Total puntos Extras');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('pair_results');
    }
}
