<?php

namespace App\Http\Controllers\Wap;

use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Distributor;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.wechat:user.web');
    }
    /**
     * Show dashboard for each user.
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request)
    {
		//$city = City::where('city_code',Auth::user()->city_code)->first();
		//$city = $city ? $city->toArray() : [];
        $skip = $request->input('skip',1);
        $distributor_id = $request->input('distributor_id','');
        if($distributor_id)
        {
            $skip = 1;
            Distributor::where('id',$distributor_id)->increment('qrcode_count');
        }
        $url_parameters = $request->all();
        if(!count($url_parameters))
        {
            User::where('openid',Auth::user()->openid)->update([
                'distributor_id' => '',
            ]);
        }
        return $this->response->title('首页')
            ->data(compact('skip','distributor_id'))
            ->view('home')
            ->output();
    }

}
