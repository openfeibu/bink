<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\City;
use App\Models\Distributor;
use App\Models\DistributorCity;
use App\Repositories\Eloquent\DistributorRepositoryInterface;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

/**
 * Resource controller class for page.
 */
class DistributorResourceController extends BaseController
{
    /**
     * Initialize page resource controller.
     *
     * @param type DistributorRepositoryInterface $distributor
     *
     */
    public function __construct(DistributorRepositoryInterface $distributor)
    {
        parent::__construct();
        $this->repository = $distributor;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request){
        $limit = $request->input('limit',config('app.limit'));

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\DistributorListPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.name'))
            ->view('distributor.index')
            ->output();
    }
    public function create(Request $request)
    {
        $distributor = $this->repository->newInstance([]);

        return $this->response->title(trans('app.name'))
            ->view('distributor.create')
            ->data(compact('distributor'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $city_codes = $attributes['city_code'];
            $data = [
                'distributor_name' => trim($attributes['distributor_name']),
            ];
            $distributor = $this->repository->create($data);

            $distributor_city_data = [];
            foreach ($city_codes as $city_code)
            {
                $distributor_city_data[] = [
                    'city_code' => $city_code,
                    'distributor_id' => $distributor->id
                ];
            }
            DistributorCity::insert($distributor_city_data);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('distributor.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('distributor/' ))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('distributor/'))
                ->redirect();
        }
    }
    public function show(Request $request,Distributor $distributor)
    {
        if ($distributor->exists) {
            $view = 'distributor.show';
        } else {
            $view = 'distributor.new';
        }
        $distributor_city_codes = DistributorCity::where('distributor_id',$distributor->id)->pluck('city_code')->toArray();

        return $this->response->title(trans('app.view') . ' ' . trans('distributor.name'))
            ->data(compact('distributor','distributor_city_codes'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Distributor $distributor)
    {
        try {
            $attributes = $request->all();

            $city_codes = $attributes['city_code'];

            DistributorCity::where('distributor_id',$distributor->id)->whereNotIn('city_code',$city_codes)->delete();

            foreach ($city_codes as $city_code)
            {
                $distributor_city =  DistributorCity::where('distributor_id',$distributor->id)->where('city_code',$city_code)->first();
                if(!$distributor_city)
                {
                    DistributorCity::create([
                        'distributor_id' => $distributor->id,
                        'city_code' => $city_code,
                    ]);
                }
            }

            return $this->response->message(trans('messages.success.created', ['Module' => trans('distributor.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('distributor/'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('distributor/'))
                ->redirect();
        }
    }
    public function destroy(Request $request,Distributor $distributor)
    {
        try {
            $distributor->forceDelete();

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('distributor.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('distributor'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('distributor'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('distributor.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('distributor'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('distributor'))
                ->redirect();
        }
    }

}