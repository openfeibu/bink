<?php

namespace App\Models;

use Hash,Auth;
use App\Models\Auth as AuthModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class DistributorShop extends AuthModel
{
    use Filer, Slugger, DateFormatter,LogsActivity;

    protected $config = 'model.distributor.distributor_shop';

    public $timestamps = false;
}