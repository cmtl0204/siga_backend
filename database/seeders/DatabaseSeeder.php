<?php

namespace Database\Seeders;

use App\Models\App\Location;
use App\Models\JobBoard\Offer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AuthenticationSeeder::class,
            JobBoardSeeder::class,
        ]);
    }
}
