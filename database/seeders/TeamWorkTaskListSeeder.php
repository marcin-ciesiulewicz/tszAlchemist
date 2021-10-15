<?php

namespace Database\Seeders;

use App\Models\TeamworkTaskList;
use Illuminate\Database\Seeder;

class TeamWorkTaskListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taskLists = [
            ['id'=>1, 'name'=>'Technical'],
            ['id'=>2, 'name'=>'Content'],
            ['id'=>3, 'name'=>'Outreach'],
            ['id'=>4, 'name'=>'Finance'],
            ['id'=>5, 'name'=>'Communication'],
        ];

        TeamworkTaskList::insert($taskLists);
    }
}
