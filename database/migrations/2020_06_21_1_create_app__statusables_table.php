<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppStatusablesTable extends Migration
{

    public function up()
    {
        Schema::connection('pgsql-app')->create('statusables', function (Blueprint $table) {
            $table->id();

            $table->foreignId('status_id')
                ->constrained('app.status');

            $table->morphs('statusable');

            $table->timestamps();
            $table->unique(['status_id','statusable_id','statusable_type']);
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('statusables');
    }
}
