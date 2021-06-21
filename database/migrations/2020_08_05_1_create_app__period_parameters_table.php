<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPeriodParametersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('period_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_period_id')->nullable()->constrained('app.school_periods'); //type string
            $table->foreignId('type_id')->nullable()->constrained('app.catalogues'); //type string
            $table->string('code');
            $table->string('name');
            $table->string('value');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('period parameters');
    }
}
