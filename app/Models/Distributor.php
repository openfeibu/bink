<?php

namespace App\Models;

use Hash,Auth;
use App\Models\Auth as AuthModel;
use App\Traits\Database\Slugger;
use App\Traits\Database\DateFormatter;
use App\Traits\Filer\Filer;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;
use QrCode;

class Distributor extends AuthModel
{
    use Filer, Slugger, DateFormatter,LogsActivity;

    protected $config = 'model.distributor.distributor';


    public function getQrcode($distributor)
    {
        $id = $distributor['id'];
        $name = $distributor['name'];
        return $this->generateQrcode($id,$name);
    }

    public function generateQrcode($id,$name)
    {
        $size = 200;
        $url = config('app.url').'?distributor_id='.$id.'&sign=distributor';
        $file_name = $name.'-'.$size.'-'.md5($url).'.svg';
        $file = storage_path('uploads').DIRECTORY_SEPARATOR.'qrcode'.DIRECTORY_SEPARATOR.$file_name;
        if(!file_exists($file))
        {
            QrCode::size($size)->generate($url, $file);
        }
        return '/qrcode/'.$file_name;
    }
}