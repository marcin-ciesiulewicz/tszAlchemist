<?php

namespace App\Console\Commands;

use App\Services\BudgetPlannerService;
use Illuminate\Console\Command;

class budgetUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'budget:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update budgets based on new currency ratings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(BudgetPlannerService $budgetPlannerService)
    {
        $this->info($budgetPlannerService->updateBudgets());
    }
}
