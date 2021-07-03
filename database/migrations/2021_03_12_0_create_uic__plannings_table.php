<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('plannings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number')->comment('numero convocatoria');
            $table->date('start_date')->comment('inicio convocatoria');
            $table->date('end_date')->comment('fin convocatoria');
            $table->string('description')->nullable();
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
        Schema::connection('pgsql-uic')->dropIfExists('plannings');
    }
}
