<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardExperiencesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('job_board.professionals');
            $table->foreignId('area_id')->constrained('app.catalogues');
            $table->string('employer');
            $table->string('position');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->json('activities');
            $table->text('reason_leave')->nullable();
            $table->boolean('is_working')->default(false);
            $table->boolean('is_disability')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('experiences');
    }
}
