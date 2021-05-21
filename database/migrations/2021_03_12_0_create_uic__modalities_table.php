<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicModalitiesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-uic')->create('modalities', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('modalities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('career_id')->constrained('app.careers');
            $table->string('name')->comment('nombre modalidad PT EC');
            $table->text('description')->nullable();
            $table->foreignId('status_id')->constrained('app.status')->comment('saber vigencia');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-uic')->dropIfExists('modalities');
    }
}
