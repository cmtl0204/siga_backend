<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobboardProfessionalsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-job-board')->create('professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('FK desde users')->constrained('authentication.users');
            $table->boolean('is_travel')->comment('Para saber si puede viajar o no el profesional, true=>puede false=no puede')->default(false);
            $table->boolean('is_disability')->default(false);
            $table->boolean('is_familiar_disability')->default(false);
            $table->boolean('identification_familiar_disability')->default(false);
            $table->boolean('is_catastrophic_illness')->default(false);
            $table->boolean('is_familiar_catastrophic_illness')->default(false);
            $table->text('about_me')->nullable()->comment('escribir una breve presentación');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-job-board')->dropIfExists('professionals');
    }
}
