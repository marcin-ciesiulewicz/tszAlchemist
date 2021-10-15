<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
          ['id'=>1, 'name'=>'Premium', 'color'=>'#fbda04'],
          ['id'=>2, 'name'=>'Standard', 'color'=>'#3c97dd'],
          ['id'=>3, 'name'=>'Local', 'color'=>'#24971c'],
          ['id'=>4, 'name'=>'Power Page', 'color'=>'#ff6600'],
        ];

        Tag::insert($tags);

    }


}
