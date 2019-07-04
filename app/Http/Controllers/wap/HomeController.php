<?php

namespace App\Http\Controllers\Wap;

use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\LBSService;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
      //  $this->middleware('auth.wechat:user.web');
    }
    /**
     * Show dashboard for each user.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
		$lbs_service = new LBSService();
        $data = $lbs_service->geocode_regeo('39.984154,116.307490');
        return $this->response->title('首页')
            ->view('home')
            ->output();
    }

}
