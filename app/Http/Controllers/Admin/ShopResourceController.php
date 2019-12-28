<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\Area;
use App\Models\City;
use App\Models\Province;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Repositories\Eloquent\ShopRepositoryInterface;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

/**
 * Resource controller class for page.
 */
class ShopResourceController extends BaseController
{
    /**
     * Initialize page resource controller.
     *
     * @param type ShopRepositoryInterface $shop
     *
     */
    public function __construct(ShopRepositoryInterface $shop)
    {
        parent::__construct();
        $this->repository = $shop;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request){
        $limit = $request->input('limit',config('app.limit'));

        if ($this->response->typeIs('json')) {
            $data = $this->repository
                ->setPresenter(\App\Repositories\Presenter\ShopListPresenter::class)
                ->orderBy('id','desc')
                ->getDataTable($limit);

            return $this->response
                ->success()
                ->count($data['recordsTotal'])
                ->data($data['data'])
                ->output();

        }
        return $this->response->title(trans('app.name'))
            ->view('shop.index')
            ->output();
    }
    public function create(Request $request)
    {
        $shop = $this->repository->newInstance([]);
        $categories = ShopCategory::orderBy('id','asc')->get();
        return $this->response->title(trans('app.name'))
            ->view('shop.create')
            ->data(compact('shop','categories'))
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
                'shop_name' => trim($attributes['shop_name']),
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
            ];

            $shop = $this->repository->create($data);
            $categories          = $request->get('categories');
            $shop->categories()->sync($categories);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('shop.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('shop/' ))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('shop/'))
                ->redirect();
        }
    }
    public function show(Request $request,Shop $shop)
    {
        if ($shop->exists) {
            $view = 'shop.show';
        } else {
            $view = 'shop.new';
        }
        $categories = ShopCategory::orderBy('id','asc')->get();
        $shop_category_ids = $shop->categories->pluck('id')->toArray();
        return $this->response->title(trans('app.view') . ' ' . trans('shop.name'))
            ->data(compact('shop','categories','shop_category_ids'))
            ->view($view)
            ->output();
    }
    public function update(Request $request,Shop $shop)
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
                'shop_name' => trim($attributes['shop_name']),
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
            ];

            $shop->update($data);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('shop.name')]))
                ->code(0)
                ->status('success')
                ->url(guard_url('shop/'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('shop/'))
                ->redirect();
        }
    }
    public function destroy(Request $request,Shop $shop)
    {
        try {
            $shop->forceDelete();

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('shop.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('shop'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('shop'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('shop.name')]))
                ->status("success")
                ->code(202)
                ->url(guard_url('shop'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('shop'))
                ->redirect();
        }
    }

}