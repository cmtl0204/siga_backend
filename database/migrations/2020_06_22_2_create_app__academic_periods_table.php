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
            $table->morphs('school_periodable');
            $table->foreignId('status_id')->constrained('app.catalogues');
            $table->string('code')->unique();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('ordinary_start_date');
            $table->date('ordinary_end_date');
            $table->date('extraordinary_start_date');
            $table->date('extraordinary_end_date');
            $table->date('especial_start_date');
            $table->date('especial_end_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('school_periods');
    }
}
