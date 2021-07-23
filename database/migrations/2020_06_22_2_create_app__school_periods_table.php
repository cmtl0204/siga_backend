<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSchoolPeriodsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-app')->create('school_periods', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->timestamps();    
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('school_periods');
    }
}
