<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-registration')->create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesh_id')->constrained('app.meshes');
            $table->foreignId('student_id')->constrained('app.students');
            $table->foreignId('school_period_id')->constrained('app.school_periods');
            $table->foreignId('academic_period_id')->constrained('app.academic_periods');
            $table->foreignId('enrollment_type_id')->constrained('registration.enrollment_types');
            $table->foreignId('working_day_id')->constrained('app.catalogues');
            $table->foreignId('working_day_operative_id')->constrained('app.catalogues');
            $table->foreignId('main_parallel')->constrained('app.catalogues');
            $table->foreignId('type_id')->constrained('app.catalogues');
            $table->string('code')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('application_date')->nullable();
            $table->dateTime('form_date')->nullable();
            $table->string('folio')->nullable();//a information es
            //defirnir estado campo
            $table->json('observations')->nullable();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::connection('pgsql-registration')->dropIfExists('enrollments');
    }
}
