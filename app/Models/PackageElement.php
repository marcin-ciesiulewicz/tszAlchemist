<?php

namespace App\Models;

use App\Models\Element;
use App\Models\FieldType;
use App\Models\TeamworkTaskList;
use App\Models\Unit;
use App\Models\Package;
use App\Models\PackageToElement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageElement extends Model
{
    use HasFactory;

    protected $table = 'package_elements';

    protected $fillable = ['name', 'status', 'notes', 'task_description', 'element_id', 'unit_id', 'field_type_id', 'teamwork_task_list_id'];

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function field_type()
    {
        return $this->belongsTo(FieldType::class, 'field_type_id');
    }

    public function teamwork_task_list()
    {
        return $this->belongsTo(TeamworkTaskList::class, 'teamwork_task_list_id');
    }


    public function package_to_element()
    {
        return $this->hasMany(PackageToElement::class);
    }

    public function package()
    {
        return $this->belongsToMany(Package::class, 'package_to_elements');
    }

}
