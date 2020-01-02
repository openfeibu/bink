<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\Area;
use App\Models\City;
use App\Models\Province;
use App\Models\Report;
use App\Models\ReportActivity;
use App\Models\ReportCategory;
use App\Repositories\Eloquent\ReportRepository;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

/**
 * Resource controller class for page.
 */
class ReportResourceController extends BaseController
{
    /**
     * Initialize page resource controller.
     *
     * @param type ReportRepository $report
     *
     */
    public function __construct(ReportRepository $report)
    {
        parent::__construct();
        $this->repository = $report;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request){
        $limit = $request->input('limit',config('app.limit'));
        $search = $request->input('search',[]);
        if ($this->response->typeIs('json')) {
            $data = $this->repository;

            $data = $data->setPresenter(\App\Repositories\Presenter\ReportListPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.name'))
            ->view('report.index')
            ->output();
    }
    public function create(Request $request)
    {
        $report = $this->repository->newInstance([]);
        $categories = ReportCategory::orderBy('id','asc')->get();
        $activities = ReportActivity::orderBy('id','asc')->get();
        return $this->response->title(trans('app.name'))
            ->view('report.create')
            ->data(compact('report','categories','activities'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();
            $business_time = $attributes['business_time'];
            $business_time_arr = explode('-',$business_time);
            $opening_time = isset($business_time_arr[0]) ? trim($business_time_arr[0]) : '';
            $closing_time = isset($business_time_arr[1]) ? trim($business_time_arr[1]) : '';
            $province = Area::where('code',$attributes['province_code'])->first();
            $city = Area::where('code',$attributes['city_code'])->first();
            $county = Area::where('code',$attributes['county_code'])->first();
            $data = [
                'report_name' => trim($attributes['report_name']),
                'province_code' => $attributes['province_code'],
                'province_name' => $province->name,
                'city_code' => $attributes['city_code'],
                'city_name' => $city->name,
                'county_code' => $attributes['county_code'],
                'county_name' => $county->name,
                'opening_time' => $opening_time,
                'closing_time' => $closing_time,
                'content' => $attributes['content'] ?? '',
                'address' => $attributes['address'] ?? '',
                'image' => $attributes['image'] ?? '',
                'longitude' => $attributes['longitude'],
                'latitude' => $attributes['latitude'],
                'images' => isset($attributes['images']) ? implode(',',$attributes['images']) : '',
                'type' => $attributes['type'],
                'tel' => $attributes['tel'] ?? '',
            ];

            $report = $this->repository->create($data);
            $categories          = $request->get('categories');
            $report->categories()->sync($categories);
            $activities          = $request->get('activities');
            $report->activities()->sync($activities);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('report.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('report/' ))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('report/'))
                ->redirect();
        }
    }
    public function show(Request $request,Report $report)
    {
        if ($report->exists) {
            $view = 'report.show';
        } else {
            $view = 'report.new';
        }
        $categories = ReportCategory::orderBy('id','asc')->get();
        $report_category_ids = $report->categories->pluck('id')->toArray();
        $activities = ReportActivity::orderBy('id','asc')->get();
        $report_activity_ids = $report->activities->pluck('id')->toArray();

        return $this->response->title(trans('app.view') . ' ' . trans('report.name'))
            ->data(compact('report','categories','report_category_ids','activities','report_activity_ids'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Report $report)
    {
        try {
            $attributes = $request->all();
            $business_time = $attributes['business_time'];
            $business_time_arr = explode('-',$business_time);
            $opening_time = isset($business_time_arr[0]) ? trim($business_time_arr[0]) : '';
            $closing_time = isset($business_time_arr[1]) ? trim($business_time_arr[1]) : '';
            $province = Area::where('code',$attributes['province_code'])->first();
            $city = Area::where('code',$attributes['city_code'])->first();
            $county = Area::where('code',$attributes['county_code'])->first();

            $data = [
                'report_name' => trim($attributes['report_name']),
                'province_code' => $attributes['province_code'],
                'province_name' => $province->name,
                'city_code' => $attributes['city_code'],
                'city_name' => $city->name,
                'county_code' => $attributes['county_code'],
                'county_name' => $county->name,
                'opening_time' => $opening_time,
                'closing_time' => $closing_time,
                'content' => $attributes['content'] ?? '',
                'address' => $attributes['address'] ?? '',
                'image' => $attributes['image'] ?? '',
                'longitude' => $attributes['longitude'],
                'latitude' => $attributes['latitude'],
                'images' => isset($attributes['images']) ? implode(',',$attributes['images']) : '',
                'type' => $attributes['type'],
                'tel' => $attributes['tel'] ?? '',
            ];

            $report->update($data);
            $categories          = $request->get('categories');
            $report->categories()->sync($categories);
            $activities          = $request->get('activities');
            $report->activities()->sync($activities);

            return $this->response->message(trans('messages.success.updated', ['Module' => trans('report.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('report/'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('report/'.$report->id))
                ->redirect();
        }
    }
    public function destroy(Request $request,Report $report)
    {
        try {
            $report->forceDelete();

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('report.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('report'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('report'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('report.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('report'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('report'))
                ->redirect();
        }
    }

}