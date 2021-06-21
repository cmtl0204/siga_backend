<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationCurricularUnitsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-registration')->create('curricular_units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-registration')->dropIfExists('curricular_units');
    }
}
