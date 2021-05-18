<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyPrerequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('cecy.courses')->comment('id_curso');
            $table->foreignId('prerequisite_id')->constrained('cecy.courses')->comment('id de cureso como preqrequisito');
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
        Schema::connection('pgsql-cecy')->dropIfExists('prerequisite');
    }
}
