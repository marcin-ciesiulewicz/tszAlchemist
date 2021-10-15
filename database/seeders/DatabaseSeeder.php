<?php

namespace Database\Seeders;

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
        $this->call([
            UserTableSeeder::class,
            ElementSeeder::class,
            UnitSeeder::class,
            FieldTypeSeeder::class,
            TeamWorkTaskListSeeder::class,
            PackageElementSeeder::class,
            CompanySeeder::class,
            CurrencySeeder::class,
            NicheSeeder::class,
            TagSeeder::class
        ]);
    }
}
