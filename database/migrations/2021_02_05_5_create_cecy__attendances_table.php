<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_registration_id')->constrained('cecy.detail_registrations');
            $table->date('date')->nullable()->comment('fecha de la asistencia');
            $table->integer('day_hours')->default(0)->nullable()->comment('total de horas que asiste en el dia');
            $table->string('assistance')->nullable()->comment('Registro de la asistencia');
            $table->json('observations')->nullable()->comment('Observaciones de la asistencia');
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
        Schema::connection('pgsql-cecy')->dropIfExists('attendances');
    }
}
