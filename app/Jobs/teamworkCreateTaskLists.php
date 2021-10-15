<?php

namespace App\Jobs;

use App\Http\Traits\StatusHelperClass;
use App\Models\Package;
use App\Services\TeamworkApiService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class teamworkCreateTaskLists implements ShouldQueue
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
    public function handle(TeamworkApiService $teamworkApiService, StatusHelperClass $statusHelperClass)
    {
        //---get all task lists for a given project and make them private
        $projectTasklists = $teamworkApiService->getProjectTaskLists($this->addedProject['id']);

        collect($projectTasklists['tasklists'])->filter(function ($value,$key) use ($teamworkApiService){

            $teamworkApiService->updateTaskList($value['id']);

        });

        //---create task lists based on package
        if(!empty($this->campaign->package_id)){
            $packge = Package::where('id',$this->campaign->package_id)->with(['package_to_element','package_to_element.package_element'])->first();

            $technicalList = collect($projectTasklists['tasklists'])->where('name', 'Technical')->pluck('id')->first();
            $financeList = collect($projectTasklists['tasklists'])->where('name', 'Finance')->pluck('id')->first();
            $contentList = collect($projectTasklists['tasklists'])->where('name', 'Content')->pluck('id')->first();
            $outreachList = collect($projectTasklists['tasklists'])->where('name', 'Outreach')->pluck('id')->first();
            $communicationList = collect($projectTasklists['tasklists'])->where('name', 'Communication')->pluck('id')->first();

            $startDate = Carbon::createFromDate($this->request['start_date'])->format('Ymd');
            $endDate = Carbon::createFromDate($this->request['start_date'])->addMonthNoOverflow(1)->format('Ymd');

            $packge->package_to_element->filter(function ($value, $key) use($technicalList, $financeList, $contentList, $outreachList, $communicationList, $startDate, $endDate ,$teamworkApiService, $statusHelperClass){

                $taskFreq = isset($value->frequency) ? $statusHelperClass::getpackageFrequencyCode()[$value->frequency] : 'norepeat';

                switch ($value->package_element->teamwork_task_list->name){
                    case 'Technical':

                        $teamworkApiService->addTaskToTaskList($technicalList, $value->package_element->name, ($value->package_element->task_description ?? '') , $startDate, $endDate, $taskFreq);
                        break;
                    case 'Finance':

                        $teamworkApiService->addTaskToTaskList($financeList, $value->package_element->name, ($value->package_element->task_description ?? '') , $startDate, $endDate, $taskFreq);
                        break;
                    case 'Content':

                        $teamworkApiService->addTaskToTaskList($contentList, $value->package_element->name, ($value->package_element->task_description ?? '') , $startDate, $endDate, $taskFreq);

                        break;
                    case 'Outreach':

                        $teamworkApiService->addTaskToTaskList($outreachList, $value->package_element->name, ($value->package_element->task_description ?? '') , $startDate, $endDate, $taskFreq);

                        break;
                    case 'Communication' :

                        $teamworkApiService->addTaskToTaskList($communicationList, $value->package_element->name, ($value->package_element->task_description ?? '') , $startDate, $endDate, $taskFreq);

                        break;
                }

            });

        }

        teamworkSendInvites::dispatch($this->request, $this->campaign, $this->addedCompany, $this->addedProject);

    }
}
