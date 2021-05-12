<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardCategoriesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-job-board')->create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('job_board.categories');
            $table->foreignId('type_id')->nullable()->constrained('app.catalogues');
            $table->string('code');
            $table->text('name');
            $table->string('icon')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('categories');
    }
}
