<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUserSeeder::class);
        $this->call(UniversityDataSeeder::class);
        $this->call(BlogDataSeeder::class);
        $this->call(NewsDataSeeder::class);
        $this->call(HomeContentSeeder::class);
        $this->call(CustomPageDataSeeder::class);
        $this->call(AboutContactPageSeeder::class);
    }
}
