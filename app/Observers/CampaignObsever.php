<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Currency;
use App\Services\BudgetPlannerService;

class CampaignObsever
{
    public function saving(Campaign $campaign)
    {
        $budgetPlannerService = new BudgetPlannerService();
        $currencyRate = Currency::find($campaign->currency_id);
        $budgetToSave = $campaign->budget_real / $currencyRate->conversion_rate;
        $campaign->budget = $budgetPlannerService->budgetHelper($budgetToSave, 10);

    }
}
