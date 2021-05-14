<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherEvalAnswersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->constrained('app.catalogues');
            $table->softDeletes();
            $table->string('code')->unique()->comment('Codigo Respuesta');
            $table->integer('order')->unique()->comment('Orden Respuesta');
            $table->string('name')->unique()->comment('Respuesta');
            $table->text('value')->comment('Valor Respuesta');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('answers');
    }
}
