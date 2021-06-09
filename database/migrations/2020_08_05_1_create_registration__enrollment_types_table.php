<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationEnrollmentTypesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-registration')->create('enrollment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-registration')->dropIfExists('enrollment_types');
    }
}
