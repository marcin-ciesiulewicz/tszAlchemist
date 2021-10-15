<?php

namespace App\Services;

use App\Models\Currency;
use GuzzleHttp\Exception\RequestException;
use http\Exception\RuntimeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\matches;

class CurrencyService
{
    /**
     * Function to get Currency rates
     * @return array|mixed|string
     */
    private function getLiveCurrencyRates()
    {
        $access_key = config('api_keys.currency_api');
        $url = 'http://api.currencylayer.com/live?access_key='.$access_key.'&currencies=GBP,EUR,AUD';


        try {
            $response = Http::get($url);

            if (!$response->json('success')){
                $errorMessage = "[CurrencyService getLiveCurrencyRates] API connection failed. Error code: {$response->json('error.code')}, message: {$response->json('error.info')}";
                Log::error($errorMessage);
                return $errorMessage;
            }
            return $response->json('quotes');

        }catch (\Throwable $t){
            $errorMessage = $t->getMessage();
            Log::error($errorMessage);
            return $errorMessage;
        }


    }

    public function updateCurrencyRates()
    {

        try {

            $conversionRates = $this->getLiveCurrencyRates();
            $currencies = Currency::all();

            if (!is_array($conversionRates)){ return $conversionRates; }

            foreach ($currencies as $currency){

                if ($currency->code === 'GBP'){
                    $currency->conversion_rate = round($conversionRates['USDGBP'],2);
                }else if ($currency->code === 'EUR'){
                    $currency->conversion_rate = round($conversionRates['USDEUR'], 2 );
                }else if ($currency->code === 'AUD'){
                    $currency->conversion_rate = round($conversionRates['USDAUD'], 2 );
                }
                $currency->save();
            }
            return 'Currencies updated successfully';
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }


}
