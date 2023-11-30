<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        App::make(RolesTableSeeder::class)->run();
        App::make(CreateAdminSeeder::class)->run();
        App::make(CreateService::class)->run();
    }
}
