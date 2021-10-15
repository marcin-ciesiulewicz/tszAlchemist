<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
          ['id' => 1, 'symbol' => '$', 'code' => 'USD', 'conversion_rate' => 1],
          ['id' => 2, 'symbol' => '£', 'code' => 'GBP', 'conversion_rate' => 0.73],
          ['id' => 3, 'symbol' => '€', 'code' => 'EUR', 'conversion_rate' => 0.86],
          ['id' => 4, 'symbol' => 'A$', 'code' => 'AUD', 'conversion_rate' => 1.37],
        ];

        Currency::insert($currencies);
        Artisan::call('currency:update');

    }
}
