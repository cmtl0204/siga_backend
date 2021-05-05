<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardCompaniesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('authentication.users');
            $table->foreignId('type_id')->constrained('app.catalogues');
            $table->foreignId('activity_type_id')->constrained('app.catalogues');
            $table->foreignId('person_type_id')->constrained('app.catalogues');
            $table->text('trade_name');
            $table->json('comercial_activities')->nullable();
            $table->string('web')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('companies');
    }
}
