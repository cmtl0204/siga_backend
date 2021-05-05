<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardOfferProfessionalTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-job-board')->create('offer_professional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');;
            $table->foreignId('offer_id')->constrained('job_board.offers');;
            $table->foreignId('status_id')->nullable()->constrained('app.status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('offer_professional');
    }
}
