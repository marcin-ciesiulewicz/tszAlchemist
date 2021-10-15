<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TeamworkApiService
{
    const TIMEOUT = 20;

    private function prepareRequest($method, $endPoint ,$query){

        $request = Http::withBasicAuth(config('api_keys.teamwork_api'), 'z')->timeout(self::TIMEOUT);

        switch (strtolower($method)){
            case 'get':
                return $request->get(config('api_keys.teamwork_url').$endPoint, $query);
            case 'post':
                return $request->post(config('api_keys.teamwork_url').$endPoint, $query);
        }

    }

    public function getProjects(string $status = 'Active')
    {
        $method = 'GET';
        $endPoint = '/projects.json';
        $query = [
            'status' => $status
        ];

        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    public function getProjectCategories()
    {
        $method = 'GET';
        $endPoint = '/projectCategories.json';
        $query = [];

        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    public function getProjectTaskLists(string $projectId)
    {
        if ($projectId !== ''){

            $method = 'GET';
            $endPoint = '/projects/'.$projectId.'/tasklists.json';
            $query = [];

            try {
                $project = $this->prepareRequest($method, $endPoint, $query);
                if ($project->successful()){
                    return $project->json();
                }else{
                    return $project->toException()->getMessage();
                }
            }catch (\Throwable $t){
                return $t->getMessage();
            }

        }else{
            return '[TeamworkApiClass getProjectTaskLists] Please provide Project id';
        }

    }

    public function getCompanies(int $page = 1, int $pageSize = 50000)
    {
        $method = 'GET';
        $endPoint = '/companies.json';
        $query = [
            'page'  => $page,
            'pageSize' => $pageSize
        ];


        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    public function getCompanyCollaborators(string $companyId)
    {

        if ($companyId !== ''){
            $method = 'GET';
            $endPoint = '/companies/'.$companyId.'/people.json';
            $query = [];

            try {
                $project = $this->prepareRequest($method, $endPoint, $query);
                if ($project->successful()){
                    return $project->json();
                }else{
                    return $project->toException()->getMessage();
                }
            }catch (\Throwable $t){
                return $t->getMessage();
            }

        }else{
            return '[TeamworkApiClass getCompanyCollaborators] Please provide Company id';
        }

    }

    public function addCompany(string $companyName)
    {
        $method = 'POST';
        $endPoint = '/companies.json';
        $query = [
            'company' => [ 'name' => $companyName ]
        ];

        $addCompany = $this->prepareRequest($method, $endPoint, $query);
        return $addCompany->json();
    }

    public function addProject(string $name, string $description, int $companyId, int $projectOwner, array $tags)
    {

        if ($name == ''){
            echo '[TeamworkApiClass addProject] Project name is required';
            return false;
        }elseif (empty($companyId)){
            echo '[TeamworkApiClass addProject] Company id is required';
            return false;
        }

        $method = 'POST';
        $endPoint = '/projects.json';
        $query = [
            'project' => [
                'name' => $name,
                'description' => $description,
                'companyId' => $companyId,
                'projectOwnerId' => $projectOwner,
                'tags'  => $tags
            ]
        ];

        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    public function addPerson(string $emailAddress, string $firstName, string $lastName, int $companyId)
    {

        if ($emailAddress == ''){
            echo '[TeamworkApiClass addPerson] Email address is required';
            return false;
        }elseif ($firstName == ''){
            echo '[TeamworkApiClass addPerson] First Name is required';
            return false;
        }elseif ($lastName == ''){
            echo '[TeamworkApiClass addPerson] Last Name is required';
        }elseif (empty($companyId)){
            echo '[TeamworkApiClass addPerson] Company id is required';
            return false;
        }

        $method = 'POST';
        $endPoint = '/people.json';
        $query = [
            'person' => [
                "email-address" => $emailAddress,
                "first-name" => $firstName,
                "last-name" => $lastName,
                "company-id" => $companyId,
                "sendInvite" => true,
                "user-type" => "collaborator"
            ]
        ];

        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    public function addTaskToTaskList(int $taskListId, string $taskName, string $description, string $startDate, string $dueDate, string $repeatFreq)
    {

        if (empty($taskListId)){
            echo '[TeamworkApiClass addTaskToTaskList] Task List id is required';
            return false;
        }elseif ($taskName == ''){
            echo '[TeamworkApiClass addTaskToTaskList] Task name is required';
            return false;
        }elseif ($repeatFreq == ''){
            echo '[TeamworkApiClass addTaskToTaskList] Task Repeat Frequency is required';
            return false;
        }

        if ($startDate !== '' && $dueDate !== ''){
            if ($this->validateDate($startDate) !== false && $this->validateDate($dueDate) !== false){
                $method = 'POST';
                $endPoint = '/tasklists/'.$taskListId.'/tasks.json';
                $query = [
                    'todo-item' => [
                        'task_list_id' => $taskListId,
                        'content'      => $taskName,
                        'notify'       => false,
                        "start-date" => $startDate,
                        "due-date" => $dueDate,
                        "description" => $description,
                        'repeatOptions' => [
                            'repeatsFreq' => $repeatFreq,
                        ]
                    ]
                ];

                try {
                    $project = $this->prepareRequest($method, $endPoint, $query);
                    if ($project->successful()){
                        return $project->json();
                    }else{
                        return $project->toException()->getMessage();
                    }
                }catch (\Throwable $t){
                    return $t->getMessage();
                }

            }else{
                echo '[TeamworkApiClass addTaskToTaskList]  Start date or due date incorrect date format. Format should be YYYYMMDD';
                return false;
            }
        }else{
            echo '[TeamworkApiClass addTaskToTaskList] Start and due dates for the task are required';
            return false;
        }

    }

    public function sendInvite(string $projectId, string $person = '')
    {
        $method = 'POST';
        $endPoint = '/projects/'.$projectId.'/people.json';
        $query = [
            "add" => [
                "userIdList" => $person
            ]
        ];

        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    public function updateTaskList(string $listId)
    {
        if ($listId == ''){
            echo '[TeamworkApiClass updateTaskList] List id is required to update the task list';
            return false;
        }

        $method = 'PUT';
        $endPoint = '/tasklists/'.$listId.'.json';
        $query = [
            "todo-list" => [
                "private" => true
            ]
        ];

        try {
            $project = $this->prepareRequest($method, $endPoint, $query);
            if ($project->successful()){
                return $project->json();
            }else{
                return $project->toException()->getMessage();
            }
        }catch (\Throwable $t){
            return $t->getMessage();
        }

    }

    /**
     * Validate date formats
     * @param $date
     * @param string $format
     * @return bool
     */
    public function validateDate($date, string $format = 'Ymd'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
