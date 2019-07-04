<?php

namespace App\Models;

use Hash,Auth;
use App\Models\Auth as AuthModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Shop extends AuthModel
{
    use Filer, Slugger, DateFormatter,LogsActivity;

    protected $config = 'model.shop.shop';

    /*
    public $appends = ['city_name'];

    public function getCityNameAttribute()
    {
        $city_name = City::where('city_code',$this->attributes['city_code'])->value('name');
        return $city_name ?? '';
    }
    */
}