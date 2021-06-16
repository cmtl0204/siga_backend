<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('project_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('uic.projects');
            $table->string('theme');
            $table->string('description');
            $table->string('act_code');
            $table->date('approval_date');
            $table->bool('is_approved');
            $table->json('observations')->nullable();
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
        Schema::connection('pgsql-uic')->dropIfExists('project_plan');
    }
}
