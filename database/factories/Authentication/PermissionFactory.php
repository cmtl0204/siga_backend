<?php

namespace Database\Factories\Authentication;

use App\Models\Authentication\Permission;
use App\Models\Authentication\System;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{

    protected $model = Permission::class;

    public function definition()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);
        return [
            'system_id' => $system->id,
            'name' => $this->faker->word(),
            'actions' => $this->faker
                ->randomElements(
                    array(
                        $catalogues['permission']['action']['post'],
                        $catalogues['permission']['action']['put'],
                        $catalogues['permission']['action']['get'],
                        $catalogues['permission']['action']['delete']),
                    random_int(1, 4))
        ];
    }
}
