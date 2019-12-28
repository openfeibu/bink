<?php

namespace App\Http\Controllers\Wap;

use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use Illuminate\Http\Request;
use App\Services\LBSService;
use App\Models\User;
use App\Models\City;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
       // $this->middleware('auth.wechat:user.web');
    }
    public function saveLocation(Request $request)
	{
		$user = User::where('openid',Auth::user()->openid)->first();
		$first = false;
		if(!$user->latitude)
		{
			$first = true;
		}
		$latitude = $request->input('latitude','');
		$longitude = $request->input('longitude','');
		$lbs_service = new LBSService();
        $data = $lbs_service->geocode_regeo($latitude.','.$longitude);
		$city_name = $data['result']['address_component']['city'];
		$city = City::where('name',$city_name)->first();
		if(!$user->latitude)
		{
			$first = true;
			User::where('openid',$user->openid)->update([
				'latitude' => $latitude,
				'longitude' => $longitude,
				'local_city' => $city_name,
                'local_city_code' => $city->city_code,
				'city' => $city_name,
				'city_code' => $city->city_code,
			]);
		}else{
			User::where('openid',$user->openid)->update([
				'latitude' => $latitude,
				'longitude' => $longitude,
				'local_city' => $city_name,
                'local_city_code' => $city->city_code,
			]);
		}
		
		return $this->response
			->status('success')
			->code(200)
			->data([
				'first' => $first,
                'city_code' => $city->city_code,
			])
			->output();
	}

}
