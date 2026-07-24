<?php

namespace Database\Seeders;

use App\Support\SitemapSync;
use Illuminate\Database\Seeder;

class SitemapEntrySeeder extends Seeder
{
    public function run()
    {
        SitemapSync::sync();
    }
}
