<?php

namespace Database\Seeders;

use App\Models\Niche;
use Illuminate\Database\Seeder;

class NicheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Niche::factory()->count(11)->create();
    }
}
