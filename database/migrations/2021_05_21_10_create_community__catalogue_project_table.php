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
<<<<<<< HEAD
            $table->foreignId('project_id')->nullable()->constrained('community.projects')->comment('FK de project ');
			$table->foreignId('area_id')->nullable()->constrained('app.catalogues')->comment('FK de la tabla catalogo area ');
			$table->foreignId('type_id')->nullable()->constrained('app.catalogues')->comment('FK de la tabla catalogo type ');
			
            //$table->softDeletes();
=======
			$table->foreignId('project_id')->nullable()->constrained('community.projects')->comment('FK de project');
            $table->foreignId('area_id')->nullable()->constrained('app.catalogues')->comment('FK de la tabla catalogo area');
            $table->foreignId('type_id')->nullable()->constrained('app.catalogues')->comment('FK de la tabla catalogo type ');                        
            
            
            $table->softDeletes();
>>>>>>> mod_5_community
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