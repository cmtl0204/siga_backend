<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id')->constrained('uic.plannings');
            $table->foreignId('name_id')->constrained('app.catalogues');
            $table->date('start_date')->comment('fecha inicio');
            $table->date('end_date')->comment('fecha fin');
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
        Schema::connection('pgsql-uic')->dropIfExists('events');
    }
}
