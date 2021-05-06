<?php

namespace Database\Seeders;

use Database\Factories\JobBoard\LocationFactory;
use Database\Factories\JobBoard\WebOfferFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AuthenticationSeeder::class,
            JobBoardSeeder::class,
        ]);

//        factory(WebOfferFactory::class, 150)->create();
    }
}
