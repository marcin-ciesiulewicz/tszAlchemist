<?php

namespace App\Jobs;


use App\Http\Traits\StatusHelperClass;
use App\Mail\NotificationEmail;
use App\Services\TeamworkApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class teamworkCreateProject implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $campaign;
    public $addedCompany;
    public $creatorEmail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $campaign, $addedCompany, $creatorEmail)
    {
        $this->addedCompany = $addedCompany;
        $this->request = $request;
        $this->campaign = $campaign;
        $this->creatorEmail = $creatorEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TeamworkApiService $teamworkApiService, StatusHelperClass $statusHelperClass)
    {
        //get project categories

        $cycleShort = $statusHelperClass::getCampaignsCycles()[$this->request['cycle']] == 'MID' || 'END' ? substr($statusHelperClass::getCampaignsCycles()[$this->request['cycle']], 0,1) : $statusHelperClass::getCampaignsCycles()[$this->request['cycle']];

        // create project
        $name = $this->request['domain'] . ' - ['.$cycleShort.']';
        $projectOwner = $this->campaign->manager_seo->teamwork_id ?? 0;
        $description = $this->request['description'] !== null ? $this->request['description'] : ' ';

        $addedProject = $teamworkApiService->addProject($name, $description ,$this->addedCompany['id'], $projectOwner, [$statusHelperClass::getCampaignsCycles()[$this->request['cycle']]]);

        //add Teamwork ID for the given campaign
        $this->campaign->teamwork_id = $addedProject['id'];

        if($this->campaign->save()){
            echo'Teamwork ID added for: '. $this->campaign->domain .' campaign';
        }else{
            echo 'Error occurred while adding Teamwork ID for:'. $this->campaign->domain .' campaign';
        }

        if ($addedProject['STATUS'] == 'Created'){

            //sen msg to raf
            $msg = 'The project <a href="' . URL::to("https://seoagency.teamwork.com/#/projects/".$addedProject['id']."/overview/activity") . '" target="_blank">'.$name.'</a> is now created and ready on Teamwork.
                    Please check all the settings, upload the proposal and leave the internal summary message.';
//            Mail::to($this->creatorEmail)->send(new NotificationEmail('New Project', ['msg'=>$msg], 'New Project added to Teamwork'));

            //fire addTasks job
            teamworkCreateTasklists::dispatch($this->request, $this->campaign, $this->addedCompany, $addedProject);

        }else{
            Log::error('Adding Project Failed!');
        }



    }

}
