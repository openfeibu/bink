<?php

namespace App\Models;

use Hash,Auth;
use App\Models\BaseModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Report extends BaseModel
{
    use Filer, Slugger, DateFormatter, LogsActivity;

    protected $config = 'model.report.report';

    public function categories()
    {
        return $this->belongsToMany(config('model.report.report_category.model'))->withTimestamps();
    }
}