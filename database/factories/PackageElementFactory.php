<?php

namespace Database\Factories;

use App\Models\Element;
use App\Models\FieldType;
use App\Models\PackageElement;
use App\Models\TeamworkTaskList;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageElementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PackageElement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name(),
            'status'=> 1,
            'notes'=> $this->faker->realText(20),
            'task_description'=> $this->faker->realText(15),
            'element_id'=> Element::all()->random(),
            'unit_id'=> Unit::all()->random(),
            'field_type_id'=> FieldType::all()->random(),
            'teamwork_task_list_id'=> TeamworkTaskList::all()->random(),
        ];
    }
}
