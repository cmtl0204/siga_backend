<?php

namespace Database\Factories\JobBoard;

use App\Models\JobBoard\Professional;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfessionalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Professional::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'about_me' => $this->faker->text($maxNbChars = 250)
        ];
    }
}
