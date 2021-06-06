<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUicTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-uic')->create('tutors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('teacher_id')->comment('id de la tabla')->constrained('app.teachers');
            $table->foreignId('type_id')->comment('para saber si es tutor, revisor ,etc')->constrained('app.catalogues');
            $table->json('observations')->comment('registro de cambios');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('pgsql-uic')->dropIfExists('tutors');
    }
}
