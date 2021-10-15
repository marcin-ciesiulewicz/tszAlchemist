<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Currency;
use App\Models\Niche;
use App\Models\Tag;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['domain', 'cycle', 'description', 'budget_real', 'payment_date', 'start_date', 'status', 'teamwork_id', 'company_id', 'manager_seo_id', 'manager_technical_id', 'currency_id', 'niche_id', 'package_id'];

    //--- relationships
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function client()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function manager_seo()
    {
        return $this->belongsTo(User::class, 'manager_seo_id');
    }

    public function manager_technical()
    {
        return $this->belongsTo(User::class, 'manager_technical_id');

    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function niche()
    {
        return $this->belongsTo(Niche::class);
    }

}
