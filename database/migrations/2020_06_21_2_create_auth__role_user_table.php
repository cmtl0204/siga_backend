<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthRoleUserTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('role_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('authentication.users');

            $table->foreignId('role_id')
                ->constrained('authentication.roles');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('role_user');
    }
}
