<?php

namespace Database\Factories\JobBoard;

use App\Models\JobBoard\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => $this->faker->numberBetween($min = 276, $max = 279),
            'parent_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'code' => $this->faker->postcode,
            'name' => $this->faker->name,
            'alpha2_code' => $this->faker->postcode,
            'alpha3_code' => $this->faker->postcode,
            'region' => $this->faker->region,
            'subregion' => $this->faker->region,
            'calling_code' => $this->faker->postcode,
            'capital' => $this->faker->postcode,
            'top_level_domain' => $this->faker->userName,
            'flag' => $this->faker->country,
            'timezones' => $this->faker->email,
        ];
    }
}
