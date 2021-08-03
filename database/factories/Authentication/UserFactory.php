<?php

namespace Database\Factories\Authentication;

use App\Models\App\Location;
use App\Models\Authentication\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{

    protected $model = User::class;

    public function definition()
    {
//        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
//        $locations = Location::where('type_id',$catalogues['location']['canton']);
        $username = $this->faker->numberBetween(1000000000, 9999999999);
        return [
            'identification' => $username,
            'username' => $username,
            'names' => $this->faker->firstNameMale,
            'first_lastname' => $this->faker->lastName,
            'second_lastname' => $this->faker->lastName,
            'personal_email' => $this->faker->unique()->safeEmail,
            'birthdate' => $this->faker->date( 'Y-m-d', 'now'),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'status_id' => 1,
            'password' => '12345678',
            'phone' => $this->faker->phoneNumber(),
            'cellphone' => $this->faker->phoneNumber(),
            'identification_type_id' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
