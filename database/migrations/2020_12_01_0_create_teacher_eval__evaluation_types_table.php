<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherEvalEvaluationTypesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-teacher-eval')->create('evaluation_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->comment('Hace tabla recursiva por eso hace referencia a una misma tabla')->constrained('evaluation_types');
            $table->softDeletes();
            $table->foreignId('status_id')->constrained('app.catalogues');
            $table->string('name')->unique()->comment('Descripcion Tipo Evaluacion');//no utilizar campos unicos
            $table->string('code')->unique()->comment('Codigo Tipo Evaluacion');
            $table->double('percentage')->nullable()->comment('Porcentaje cada Tipo Evaluacion');;
            $table->double('global_percentage')->nullable()->comment('Este porcentaje es para calculos finales.');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::connection('pgsql-teacher-eval')->dropIfExists('evaluation_types');
    }
}
