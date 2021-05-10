<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthUsersTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-authentication')->create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ethnic_origin_id')
                ->nullable()
                ->constrained('app.catalogues');

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('app.address');

            $table->foreignId('identification_type_id')
                ->nullable()
                ->constrained('app.catalogues');

            $table->foreignId('sex_id')
                ->nullable()
                ->constrained('app.catalogues');

            $table->foreignId('gender_id')
                ->nullable()
                ->constrained('app.catalogues');

            $table->foreignId('status_id')
                ->nullable()
                ->constrained('app.status');

            $table->foreignId('blood_type_id')
                ->nullable()
                ->constrained('app.catalogues');

            $table->foreignId('civil_status_id')
                ->nullable()
                ->constrained('app.catalogues');

            $table->string('avatar')
                ->nullable()
                ->unique();

            $table->string('security_image')
                ->nullable();

            $table->string('username')
                ->unique();

            $table->string('identification')
                ->unique();

            $table->string('first_name')
                ->nullable();

            $table->string('second_name')
                ->nullable();

            $table->string('first_lastname')
                ->nullable();

            $table->string('second_lastname')
                ->nullable();

            $table->string('personal_email')
                ->nullable()->unique();

            $table->date('birthdate')
                ->nullable();

            $table->string('email')
                ->unique();

            $table->string('phone')
                ->nullable();

            $table->timestamp('email_verified_at')
                ->nullable();

            $table->string('password')
                ->nullable();

            $table->boolean('is_changed_password')
                ->default(false);

            $table->integer('attempts')
                ->default(\App\Models\Authentication\User::ATTEMPTS);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-authentication')->dropIfExists('users');
    }
}
