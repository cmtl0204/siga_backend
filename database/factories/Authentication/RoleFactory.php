<?php

namespace Database\Factories\Authentication;

use App\Models\Authentication\Role;
use App\Models\Authentication\System;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);
        return [
            'system_id' => $system->id,
        ];
    }
}
