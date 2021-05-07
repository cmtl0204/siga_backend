<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppCareersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('careers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('app.institutions');
            $table->foreignId('modality_id')->constrained('app.catalogues');
            $table->foreignId('type_id')->constrained('app.catalogues');
            $table->string('code')->nullable();;
            $table->string('name')->nullable();

            $table->text('description')->nullable();
            $table->text('short_name');
            $table->string('resolution_number')->nullable();
            $table->string('title');
            $table->string('acronym');
            $table->string('logo');
            $table->json('learning_results')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->string('codigo_sniese', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('careers');
    }
}
