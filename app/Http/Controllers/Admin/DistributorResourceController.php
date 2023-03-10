<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\City;
use App\Models\Distributor;
use App\Models\DistributorCity;
use App\Models\DistributorShop;
use App\Repositories\Eloquent\DistributorRepositoryInterface;
use App\Repositories\Eloquent\ShopRepositoryInterface;
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
     * @param type ShopRepositoryInterface $shop_repository
     *
     */
    public function __construct(DistributorRepositoryInterface $distributor,ShopRepositoryInterface $shop_repository)
    {
        parent::__construct();
        $this->repository = $distributor;
        $this->shop_repository = $shop_repository;
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

        $shop_tree = $this->shop_repository->getShopTree();

        return $this->response->title(trans('app.name'))
            ->view('distributor.create')
            ->data(compact('distributor','shop_tree'))
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $shop_ids = $attributes['shop_id'];
            $data = [
                'distributor_name' => trim($attributes['distributor_name']),
            ];
            $distributor = $this->repository->create($data);

            $distributor_shop_data = [];
            foreach ($shop_ids as $shop_id)
            {
                $distributor_shop_data[] = [
                    'shop_id' => $shop_id,
                    'distributor_id' => $distributor->id
                ];
            }
            DistributorShop::insert($distributor_shop_data);

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
        //$distributor_city_codes = DistributorCity::where('distributor_id',$distributor->id)->pluck('city_code')->toArray();
        $distributor_shop_ids = DistributorShop::where('distributor_id',$distributor->id)->pluck('shop_id')->toArray();

        $shop_tree = $this->shop_repository->getShopTree();

        return $this->response->title(trans('app.view') . ' ' . trans('distributor.name'))
            ->data(compact('distributor','distributor_shop_ids','shop_tree'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Distributor $distributor)
    {
        try {
            $attributes = $request->all();

            $shop_ids = $attributes['shop_id'];

            DistributorShop::where('distributor_id',$distributor->id)->whereNotIn('shop_id',$shop_ids)->delete();

            foreach ($shop_ids as $shop_id)
            {
                $distributor_shop =  DistributorShop::where('distributor_id',$distributor->id)->where('shop_id',$shop_id)->first();
                if(!$distributor_shop)
                {
                    DistributorShop::create([
                        'distributor_id' => $distributor->id,
                        'shop_id' => $shop_id,
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