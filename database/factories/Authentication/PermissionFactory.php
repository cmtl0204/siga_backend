<?php

namespace Database\Factories\Authentication;

use App\Models\Authentication\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{

    protected $model = Permission::class;

    public function definition()
    {
            $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        return [
            'name' => $this->faker->word,
            'actions' => $this->faker
                ->randomElements(
                    $array = array(
                        $catalogues['permission']['action']['post'],
                        $catalogues['permission']['action']['put'],
                        $catalogues['permission']['action']['get'],
                        $catalogues['permission']['action']['delete']),
                    $count = random_int(1, 4))
        ];
    }
}
