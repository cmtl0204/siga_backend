<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthSecurityQuestionsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('security_questions', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('security_questions');
    }
}
