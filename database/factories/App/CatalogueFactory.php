<?php

namespace Database\Factories\App;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogueFactory extends Factory
{

    protected $model = Catalogue::class;

    public function definition()
    {
        return [
            'code' => $this->faker->ean8(),
            'name' => $this->faker->sentence(),
            'type' => $this->faker->word(),
            'icon' => $this->faker->word(),
            'color' => $this->faker->hexColor(),

        ];
    }
}
