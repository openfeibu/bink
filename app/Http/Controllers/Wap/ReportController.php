<?php

namespace App\Http\Controllers\Wap;

use App\Models\Distributor;
use App\Models\DistributorShop;
use App\Repositories\Eloquent\ReportRepository;
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
    public function __construct(
        Request $request,
        ReportRepository $reportRepository
    )
    {
        parent::__construct();
        $this->middleware('auth.wechat:user.web');
        $this->reportRepository = $reportRepository;
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
    public function submitReport(Request $request)
    {
        try {
            $attributes = $request->all();
            $attributes['user_id'] = Auth::user()->id;
            $report = $this->reportRepository->create($attributes);
            $categories          = $request->get('categories');
            $report->categories()->sync($categories);

            return $this->response->message('感谢您的反馈！')
                ->code(0)
                ->status('success')
                ->url(guard_url('/' ))
                ->redirect();

        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('report/'))
                ->redirect();
        }
    }


}
