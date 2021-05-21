<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitySignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('signatures', function (Blueprint $table) {
	    $table->id();
	    $table->foreignId('person_id')->constrained('community.project_participants');
	    $table->string('position')->comment('string, que escribe el cargo');
	    $table->string('type')->comment('String, se escribe elaborado, revison, xx');
	    $table->foreignId('itv_id')->nullable()->constrained('community.itvs');
	    $table->foreignId('project_id')->nullable()->constrained('community.projects');
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
        Schema::connection('pgsql-community')->dropIfExists('signatures');
    }
}
