<?php

namespace App\Jobs;

use App\Models\Company;
use App\Services\TeamworkApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class teamworkCreateCompany implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $request;
    public $campaign;
    public $creatorEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $campaign, $creatorEmail)
    {
        $this->request = $request;
        $this->campaign = $campaign;
        $this->creatorEmail = $creatorEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TeamworkApiService $teamworkApiService)
    {
        $allCompanies = $teamworkApiService->getCompanies();

        $clientCompany = Company::find($this->request['company_id']);

        if (!collect($allCompanies['companies'])->contains('name', $clientCompany->name)) {
            //---company doesn't exists in teamwork

            // create an company
            $addedCompany = $teamworkApiService->addCompany($clientCompany->name);

            //add teamworkid for the given company
            $clientCompany->teamwork_id = $addedCompany['id'];
            if($clientCompany->save()){
                echo'Teamwork ID added for: '. $clientCompany->name . ' company';
            }else{
                echo 'Error occurred while adding Teamwork ID for: '. $clientCompany->name . ' company';
            }

            if ($addedCompany['STATUS'] == 'Created'){

                //fire addProject job
                teamworkCreateProject::dispatch($this->request, $this->campaign, $addedCompany, $this->creatorEmail);

            }else{
                Log::error('Adding Company Failed!');
            }

        } else {
            //company exists
            $existingCompanyId = ['id' => collect($allCompanies['companies'])->where('name', $clientCompany->name)->pluck('id')->first()];

            //fire addProject job
            teamworkCreateProject::dispatch($this->request, $this->campaign, $existingCompanyId, $this->creatorEmail);

        }
    }
}
