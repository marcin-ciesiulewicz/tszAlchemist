<?php

namespace App\Models;

use App\Models\PackageElement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageToElement extends Model
{
    use HasFactory;


    //relations
    public function package_element()
    {
        return $this->belongsTo(PackageElement::class);
    }

}
