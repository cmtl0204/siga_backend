<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardReferencesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-job-board')->create('references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');;
            $table->string('institution');
            $table->string('position');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('references');
    }
}
