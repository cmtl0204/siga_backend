<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardCompanyProfessionalTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('company_professional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('job_board.companies');;
            $table->foreignId('professional_id')->constrained('job_board.professionals');;
            $table->foreignId('status_id')->nullable()->constrained('app.status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('company_professional');
    }
}
