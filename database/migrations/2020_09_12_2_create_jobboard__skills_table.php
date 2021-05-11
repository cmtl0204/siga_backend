<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardSkillsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-job-board')->create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');
            $table->foreignId('type_id')->comment('soft or hard')->constrained('app.catalogues');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('skills');
    }
}
