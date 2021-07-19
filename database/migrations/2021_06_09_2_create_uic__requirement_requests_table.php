<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicRequirementRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('requirement_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requirement_id')->constrained('uic.requirements');
            $table->foreignId('mesh_student_id')->constrained('app.mesh_student');
            $table->date('date');
            $table->boolean('is_approved')->comment('true si es requerido');
            $table->json('observations')->nullable();
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
        Schema::connection('pgsql-uic')->dropIfExists('requirement_requests');
    }
}
