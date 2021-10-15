<?php

namespace Database\Seeders;

use App\Models\FieldType;
use Illuminate\Database\Seeder;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fieldtypes = [
            ['id'=>1, 'name'=>'Number'],
            ['id'=>2, 'name'=>'Binary'],
        ];

        FieldType::insert($fieldtypes);
    }
}
