<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardLanguagesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');;
            $table->foreignId('idiom_id')->constrained('app.catalogues');
            $table->foreignId('written_level_id')->constrained('app.catalogues');
            $table->foreignId('spoken_level_id')->constrained('app.catalogues');
            $table->foreignId('read_level_id')->constrained('app.catalogues');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('languages');
    }
}
