<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyEvaluationMechanismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('evaluation_mechanisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')
                ->comment('FK curso')
                ->constrained('cecy.courses'); //
            $table->foreignId('type_id')
                ->comment('evaluacion diagnostica, evaluacion proceso formativo y evaluacion final')
                ->constrained('app.catalogues');
            $table->string('technique');
            $table->string('instrument');
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
        Schema::connection('pgsql-cecy')->dropIfExists('evaluation_mechanisms');
    }
}
