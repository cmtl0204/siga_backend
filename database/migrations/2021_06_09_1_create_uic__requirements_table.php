<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_id')->constrained('app.careers');
            $table->string('name');
            $table->boolean('is_required')->comment('true si es requerido');
            $table->boolean('is_solicitable')->comment('para saber si la institución puede otorgar el requerimiento');
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
        Schema::connection('pgsql-uic')->dropIfExists('requirements');
    }
}
