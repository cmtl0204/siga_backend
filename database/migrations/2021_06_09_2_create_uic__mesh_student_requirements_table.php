<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicMeshStudentRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('mesh_student_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesh_student_id')->constrained('app.mesh_student');
            $table->foreignId('requirement_id')->constrained('uic.requirements');
            $table->boolean('is_approved')->nullable();
            $table->text('observations')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('pgsql-uic')->dropIfExists('mesh_student_requirements');
    }
}
