<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('projects', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('enrollment_id')->constrained('uic.enrollments');
            $table->foreignId('project_plan_id')->constrained('uic.project_plans');
            $table->string('title')->comment('titulo');
            $table->string('description');
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
        Schema::connection('pgsql-uic')->dropIfExists('projects');
    }
}
