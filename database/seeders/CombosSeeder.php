<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\App\Catalogue;
use Illuminate\Support\Facades\DB;

class CombosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

     {
           //status
            Catalogue::factory()->create([
                'code' => '1',
                'name' => 'UNIDADES DE COMPETENCIA / PROCESOS',
                'type' => 'type_id',

            ]);
            Catalogue::factory()->create([
                'code' => '2',
                'name' => 'ELEMENTOS DE COMPETENCIA / SUB-PROCESOS',
                'type' => 'type_id',

            ]);
            Catalogue::factory()->create([
                'code' => '3',
                'name' => 'RESULTADOS DE APRENDIZAJE / ACTIVIDADES',
                'type' => 'type_id',

            ]);
            Catalogue::factory()->create([
                'code' => '4',
                'name' => 'FORMAS DE EVIDENCIAR A LOS R.D.A.',
                'type' => 'type_id',

            ]);

            Catalogue::factory()->create([
                'code' => '5',
                'name' => 'FORMAS DE EVIDENCIAR A LOS R.D.A.',
                'type' => 'type_id',

            ]);







    }
}
