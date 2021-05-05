<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardAcademicFormationsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-job-board')->create('academic_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');
            $table->foreignId('professional_degree_id')->constrained('job_board.categories');
            $table->date('registration_date')->nullable();
            $table->string('senescyt_code')->nullable();
            $table->boolean('has_titling')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('academic_formations');
    }
}
