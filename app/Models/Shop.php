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

    protected $appends = ['type_desc'];

    public function categories()
    {
        return $this->belongsToMany(config('model.shop.shop_category.model'))->withTimestamps();
    }
    public function activities()
    {
        return $this->belongsToMany(config('model.shop.shop_activity.model'))->withTimestamps();
    }

    public function getTypeDescAttribute()
    {
        return trans('shop.type.'.$this->attributes['type']);
    }
}