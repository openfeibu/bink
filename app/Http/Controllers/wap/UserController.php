<?php

namespace App\Http\Controllers\Wap;

use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth.wechat:user.web');
    }
    public function saveLocation(Request $request)
	{
		$user = Auth::user();
		$latitude = $request->input('latitude','');
		$longitude = $request->input('longitude','');
		
	}

}
