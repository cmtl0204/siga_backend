<?php

namespace Database\Factories\App;

use App\Models\App\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'type_id' => $this->faker->numberBetween($min = 276, $max = 279),
//            'parent_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'code' => $this->faker->postcode,
            'name' => $this->faker->name,
            'alpha2_code' => $this->faker->postcode,
            'alpha3_code' => $this->faker->postcode,
            'region' => $this->faker->userName,
            'subregion' => $this->faker->userName,
            'calling_code' => $this->faker->postcode,
            'capital' => $this->faker->postcode,
            'top_level_domain' => $this->faker->userName,
            'flag' => $this->faker->country,
//            'timezones' => $this->faker->text,
        ];
    }
}
