<?php

namespace App\Models;

use App\Models\PackageElement;
use App\Models\PackageToElement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    //relations
    public function package_to_element()
    {
        return $this->hasMany(PackageToElement::class);
    }

    public function package_element()
    {
        return $this->belongsToMany(PackageElement::class, 'package_to_elements')->withPivot(['amount','frequency','is_first_month']);
    }

}
