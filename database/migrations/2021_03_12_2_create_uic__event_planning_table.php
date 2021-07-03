<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicEventPlanningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('event_planning', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id')->constrained('uic.plannings');
            $table->foreignId('event_id')->constrained('uic.events');
            $table->date('start_date')->comment('inicio evento');
            $table->date('end_date')->comment('fin evento');
            $table->json('observations');
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
        Schema::connection('pgsql-uic')->dropIfExists('event_planning');
    }
}
