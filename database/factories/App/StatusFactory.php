<?php

namespace Database\Factories\App;

use App\Models\App\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{

    protected $model = Status::class;

    public function definition()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        return [

        ];
    }
}
