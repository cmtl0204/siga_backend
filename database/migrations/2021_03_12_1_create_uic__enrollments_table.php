<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicEnrollmentsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-uic')->create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modality_id')->constrained('uic.modalities');
            $table->foreignId('school_period_id')->constrained('app.school_periods');
            // $table->foreignId('mesh_student_id')->constrained('app.mesh_student') no hay la tabla;
            $table->date('date')->comment('fecha matricula');
            $table->string('code');
            $table->foreignId('status_id')->constrained('app.status')->comment('saber si perdio, anulo');
            $table->foreignId('planning_id')->constrained('uic.plannings')->comment('saber el evento al que pertenece');
            $table->json('observations')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-uic')->dropIfExists('enrollments');
    }
}
