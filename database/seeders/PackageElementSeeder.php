<?php

namespace Database\Seeders;

use App\Models\PackageElement;
use Illuminate\Database\Seeder;

class PackageElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PackageElement::factory()
            ->count(15)
            ->create();
    }
}
