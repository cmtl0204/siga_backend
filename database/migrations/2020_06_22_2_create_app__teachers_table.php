<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTeachersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
        
    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('teachers');
    }
}
