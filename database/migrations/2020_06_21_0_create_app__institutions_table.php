<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInstitutionsTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('institutions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('app.address');

            $table->string('code')
                ->comment('Generado automaticamente por el acronym y el id ej: abc1');

            $table->string('denomination')
                ->nullable();

            $table->string('name');

            $table->string('short_name');

            $table->string('acronym')
                ->nullable();

            $table->string('email')
                ->nullable()
                ->comment('correo electronico principal');

            $table->text('slogan')
                ->nullable();

            $table->string('logo')
                ->nullable();

            $table->string('web')
                ->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->string('codigo_sniese', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('institutions');
    }
}
