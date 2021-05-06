<?php

namespace Database\Factories\JobBoard;

use App\Models\JobBoard\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebOfferFactory extends Factory
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
            'company_id' => $this->faker->numberBetween($min = 1, $max = 11),
            'location_id' => 1,
            'contract_type_id' => 1,
            'position_id' => 1,
            'sector_id' => 1,
            'working_day_id' => 1,
            'experience_time_id' => 1,
            'training_hours_id' => 1,
            'status_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'code' => $this->faker->postcode,
            'description' => $this->faker->realText($maxNbChars = 200, $indexSize = 15),
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
