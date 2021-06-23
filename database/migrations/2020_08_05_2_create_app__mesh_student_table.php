<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppMeshStudentTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('mesh_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('app.students');
            $table->foreignId('mesh_id')->constrained('app.meshes');
            $table->date('start_cohort')->nullable();
            $table->date('end_cohort')->nullable();
            $table->boolean('is_graduated')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('mesh_student');
    }
}
