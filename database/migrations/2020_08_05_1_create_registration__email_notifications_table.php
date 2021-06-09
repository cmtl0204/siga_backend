<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationEmailNotificationsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-registration')->create('email_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->nullable()->constrained('app.catalogues'); //type string
            $table->string('name');
            $table->string('lastname');
            $table->string('email');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-registration')->dropIfExists('email_notifications');
    }
}
