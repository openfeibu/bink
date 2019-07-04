<?php

namespace App\Http\Controllers\Wap;

use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;

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
    public function home()
    {
		//$city = City::where('city_code',Auth::user()->city_code)->first();
		//$city = $city ? $city->toArray() : [];
        return $this->response->title('首页')
            ->view('home')
            ->output();
    }

}
