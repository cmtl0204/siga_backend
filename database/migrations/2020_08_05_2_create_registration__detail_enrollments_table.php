<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationDetailEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-registration')->create('detail_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parallel_id')->constrained('app.catalogues');
            $table->foreignId('working_day_id')->constrained('app.catalogues');
            $table->foreignId('enrollment_type_id')->constrained('registration.enrollment_types');
            $table->foreignId('enrollment_id')->constrained('registration.enrollments');
            $table->integer('enrollment_number')->nullable();
            $table->json('observations')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-registration')->dropIfExists('detail_enrollments');
    }
}
