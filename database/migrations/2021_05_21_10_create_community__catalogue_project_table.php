<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityCatalogueProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	 
    public function up()
    {
        Schema::connection('pgsql-community')->create('catalogue_project', function (Blueprint $table) {
            $table->id();
			$table->string('code')->nullable()->comment('Codigo del convenio.'); //codigo correspondiente al convenio, ejemplo VC-ISTBJ-2019-002
            $table->foreignId('project_id')->comment('FK de project ')->connstrained('community.projects');
			$table->foreignId('area_id')->comment('FK de la tabla catalogo area ')->connstrained('app.catalogues');
			$table->foreignId('type_id')->comment('FK de la tabla catalogo type ')->connstrained('app.catalogues');
			
            //$table->softDeletes();
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
        Schema::dropIfExists('catalogue_project');
    }
}