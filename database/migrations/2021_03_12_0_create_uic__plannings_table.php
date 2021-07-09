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
            $table->foreignId('career_id')->constrained('app.careers');
            $table->string('name')->nullable()->comment('UIC 2021-1');
            $table->date('start_date')->comment('fecha inicio');
            $table->date('end_date')->comment('fecha fin');
            $table->string('description')->nullable()->comment('descripcion evento');
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
