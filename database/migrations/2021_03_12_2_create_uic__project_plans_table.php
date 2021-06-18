<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicProjectPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('project_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('act_code');
            $table->date('approval_date');
            $table->boolean('is_approved');
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
        Schema::connection('pgsql-uic')->dropIfExists('project_plans');
    }
}
