<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;

class BudgetPlannerService
{

    /**
     * Function to update budgets based on new currency conversion rates
     * @return string
     */
    public function updateBudgets() : string
    {

        try {

            $currencies = Currency::all();
            $gbp = $currencies->firstWhere('code', 'GBP');
            $eur = $currencies->firstWhere('code', 'EUR');
            $aud = $currencies->firstWhere('code', 'AUD');

            $campaigns = Campaign::all();

            foreach ($campaigns as $campaign){

                switch ($campaign->currency_id){
                    case $gbp->id:
                        $campaign->budget = $this->budgetHelper(($campaign->budget_real/$gbp->conversion_rate),10);
                        break;
                    case $eur->id:
                        $campaign->budget = $this->budgetHelper(($campaign->budget_real/$eur->conversion_rate),10);
                        break;
                    case $aud->id:
                        $campaign->budget = $this->budgetHelper(($campaign->budget_real/$aud->conversion_rate),10);
                        break;
                }
                //Save Campaign budget without triggering Model Events
                $campaign->saveQuietly();

            }

            return 'Budgets updated successfully';

        }catch (\Throwable $t){
            Log::error("[BudgetPlanner Service updateBudgets] Error occurred while updating budgets. Error: {$t->getMessage()}");
            return 'Error occurred while updating budgets. Check log file.';
        }

    }

    /**
     * @param float $budget
     * @param int $decimal
     * @return float|int
     */
    public function budgetHelper(float $budget, int $decimal = 5) : float
    {
        return floor($budget/$decimal) * $decimal;
    }
}
