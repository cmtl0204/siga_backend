<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityAddressEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql-community')->create('address_entity', function (Blueprint $table) {
	    $table->id();
	    $table->foreignId('location_id')->constrained('app.locations');
	    $table->foreignId('entitie_id')->constrained('community.entities');
	    $table->foreignId('entitie_type_id')->constrained('app.catalogues');
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
        Schema::connection('pgsql-community')->dropIfExists('address_entity');
    }
}
