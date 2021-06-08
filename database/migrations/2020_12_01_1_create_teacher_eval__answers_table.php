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
            $table->foreignId('status_id')->constrained('app.catalogues')->schema('pgsql-teacher-eval');
            $table->string('code')->comment('Codigo Respuesta');
            $table->integer('order')->comment('Orden Respuesta');
            $table->string('name')->comment('Respuesta');
            $table->text('value')->comment('Valor Respuesta');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('answers');
    }
}
