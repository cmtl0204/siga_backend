<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-cecy')->create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('authentication.users')->comment('usuario de autenticación');//
            $table->foreignId('type_id')->constrained('app.catalogues')->comment('Un instructor puede ser de la setec o docente de la senescyt');
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
        Schema::connection('pgsql-cecy')->dropIfExists('instructors');
    }
}
