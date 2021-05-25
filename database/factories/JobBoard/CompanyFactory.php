<?php

namespace Database\Factories\JobBoard;

use App\Models\JobBoard\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'prefix' => $this->faker->cityPrefix,
            'trade_name' => $this->faker->company,
            'web' => $this->faker->url,
        ];
    }
}
