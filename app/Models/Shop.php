<?php

namespace App\Models;

use Hash,Auth;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Shop extends BaseModel
{
    use Filer, Slugger, DateFormatter,LogsActivity;

    protected $config = 'model.shop.shop';

    protected $appends = ['type_desc'];

    public function categories()
    {
        return $this->belongsToMany(config('model.shop.shop_category.model'));
    }
    public function activities()
    {
        return $this->belongsToMany(config('model.shop.shop_activity.model'));
    }

    public function getTypeDescAttribute()
    {
        return trans('shop.type.'.$this->attributes['type']);
    }
}