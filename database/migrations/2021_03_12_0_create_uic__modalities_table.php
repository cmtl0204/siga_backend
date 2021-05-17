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
            $table->foreignId('parent_id')->constrained('uic.modalities');
            $table->foreignId('career_id')->constrained('app.careers');
            $table->string('name')->comment('nombre modalidad');
            $table->text('description')->nullable();
            $table->foreignId('status_id')->constrained('app.catalogues')->comment('saber vigencia');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-uic')->dropIfExists('modalities');
    }
}
