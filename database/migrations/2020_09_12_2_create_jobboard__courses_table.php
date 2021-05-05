<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardCoursesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');;
            $table->foreignId('type_id')->comment('tipo de evento')->constrained('app.catalogues');
            $table->foreignId('institution_id')->constrained('app.catalogues');
            $table->foreignId('certification_type_id')->constrained('app.catalogues');
            $table->foreignId('area_id')->constrained('app.catalogues');
            $table->text('name');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('hours');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('courses');
    }
}
