<?php

namespace Database\Factories\JobBoard;

use App\Models\JobBoard\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->numberBetween(1, 11),
            'location_id' => 1, // no hay nada
            'contract_type_id' => $this->faker->numberBetween(276, 279),
            'position_id' => $this->faker->numberBetween(280, 299),
            'sector_id' => $this->faker->numberBetween(280, 299), // preguntar
            'working_day_id' => $this->faker->numberBetween(300, 319),
            'experience_time_id' => $this->faker->numberBetween(320, 339),
            'training_hours_id' => $this->faker->numberBetween(340,359),
            'status_id' => $this->faker->numberBetween(1, 5),
            'code' => $this->faker->postcode,
            'description' => $this->faker->realText($maxNbChars = 200, $indexSize = 5),
            'contact_name' => $this->faker->userName,
            'contact_email' => $this->faker->email,
            'contact_phone' => $this->faker->phoneNumber,
            'contact_cellphone' => $this->faker->phoneNumber,
            'remuneration' => $this->faker->buildingNumber,
            'vacancies' => $this->faker->randomDigitNotNull,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'activities' => $this->faker->text,
            'requirements' => $this->faker->text,
            'aditional_information' => $this->faker->text,
        ];
    }
}
