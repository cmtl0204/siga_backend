<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppAcademicPeriodablesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('academic_periodables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_period_id')->constrained('app.academic_periods');
            $table->morphs('academic_periodable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('academic_periodables');
    }
}
