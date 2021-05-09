<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSubjectsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-app')->create('subjects', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->text('objective')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('subjects');
    }
}
