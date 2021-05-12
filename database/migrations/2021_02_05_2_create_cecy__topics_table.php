<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('cecy.topics')
                ->comment('codigo padre del tema, apunta al id de esta misma tabla');
            $table->foreignId('course_id')->constrained('cecy.courses')
                ->comment('FK de la tabla cursos');
            $table->foreignId('type_id')->constrained('app.catalogues')
                ->comment('tipo de tema, principal  o subtema');
            $table->text('description')->nullable()->comment('descripcion del tema');
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
        Schema::connection('pgsql-cecy')->dropIfExists('topics');
    }
}
