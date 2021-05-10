<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthPermissionRoleTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('permission_role', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                ->constrained('authentication.roles');

            $table->foreignId('permission_id')
                ->constrained('authentication.permissions');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('permission_role');
    }
}
