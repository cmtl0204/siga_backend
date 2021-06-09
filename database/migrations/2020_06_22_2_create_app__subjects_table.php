<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSubjectsTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-app')->create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesh_id')->constrained('app.meshes');
            $table->foreignId('academic_period_id')->constrained('registration.academic_periods');
            $table->foreignId('curricular_unit_id')->constrained('registration.curricular_units');
            $table->foreignId('type_id')->constrained('app.catalogues');
            $table->foreignId('training_camp_id')->constrained('app.training_camps');
            $table->foreignId('prerequisite_parent_id')->constrained('app.subjects');
            $table->foreignId('corequisite_parent_id')->constrained('app.subjects');
            $table->string('code');
            $table->string('name');
            $table->text('description');
            $table->text('objective');
            $table->integer('teaching_hours');
            $table->integer('teaching_hours');
            $table->integer('autonomous_hours');
            $table->integer('number_weeks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('subjects');
    }
}
