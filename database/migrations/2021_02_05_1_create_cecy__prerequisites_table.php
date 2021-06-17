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
            $table->foreignId('course_id')->constrained('courses')->comment('id_curso');
            $table->foreignId('state_id')->constrained('app.status')->comment('id_curso');
            $table->bigInteger('parent_code_id')->nullable()->comment('campo del padre');
            $table->foreign('parent_code_id')->references('id')->on('prerequisites')->comment('id de su propia tabla (recursiva)');
            $table->timestamps();
            $table->softDeletes();
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