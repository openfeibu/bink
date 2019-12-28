<?php

namespace App\Http\Controllers\Wap;

use App\Models\Distributor;
use App\Models\DistributorShop;
use Illuminate\Http\Request;
use Route,Auth,DB;
use App\Http\Controllers\Wap\Controller as BaseController;
use App\Models\Shop;
use App\Models\User;
use App\Models\City;
use App\Models\Area;
use App\Models\DistributorCity;

class ReportController extends BaseController
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware('auth.wechat:user.web');
    }
    /**
     * Show dashboard for each user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return $this->response->title('留言')
            //->data(compact('city','search_key','city_code','distributor_id'))
            ->view('report.index')
            ->output();

    }

}
