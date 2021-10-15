<?php

namespace Database\Seeders;

use App\Models\Element;
use Illuminate\Database\Seeder;

class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = [
            [
                'id' => 1,
                'name' => 'Time'
            ],
            [
                'id' => 2,
                'name' => 'Word'
            ],
            [
                'id' => 3,
                'name' => 'Link'
            ],
            [
                'id' => 4,
                'name' => 'Option'
            ],
        ];

        foreach ($elements as $element){
            Element::create($element);
        }

    }
}
