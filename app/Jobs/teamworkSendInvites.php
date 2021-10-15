<?php

namespace App\Jobs;

use App\Services\TeamworkApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class teamworkSendInvites implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $campaign;
    public $addedProject;
    public $addedCompany;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $campaign ,$addedCompany, $addedProject)
    {
        $this->request = $request;
        $this->campaign = $campaign;
        $this->addedCompany = $addedCompany;
        $this->addedProject = $addedProject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TeamworkApiService $teamworkApiService)
    {
        $companyCollaborators = $teamworkApiService->getCompanyCollaborators($this->addedCompany['id']);

        if (empty((array_filter($this->request['first_name'])))){
            Log::info('Invite form empty. No person added');
            return;
        }

        //send invites to users from the form
        for ($i=0; $i<count((array_filter($this->request['first_name']))); $i++) {

            //if email exists skip adding to company and send invite
            if (collect($companyCollaborators['people'])->contains('email-address', $this->request['email'][$i])){

                //use existing users to send them invites
                $teamworkApiService->sendInvite($this->addedProject['id'], collect($companyCollaborators['people'])->where('email-address', $this->request['email'][$i])->pluck('id')->first());

            }else{

                //add person to company
                $addedPerson = $teamworkApiService->addPerson($this->request['email'][$i], $this->request['first_name'][$i], $this->request['last_name'][$i], $this->addedCompany['id']);

                //use response of added users to send them invites
                $teamworkApiService->sendInvite($this->addedProject['id'], $addedPerson['id']);
            }

        }

    }
}
