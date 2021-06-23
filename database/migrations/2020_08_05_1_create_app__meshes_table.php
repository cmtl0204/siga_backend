<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppMeshesTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('meshes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('careers_id')->constrained('app.careers');
            $table->string('name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('resolution_number')->nullable();
            $table->integer('number_weeks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('meshes');
    }
}
