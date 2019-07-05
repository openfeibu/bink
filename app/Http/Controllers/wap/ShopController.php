<?php

namespace App\Http\Controllers\Wap;

use App\Models\Distributor;
use App\Models\DistributorShop;
use Illuminate\Http\Request;
use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use App\Models\Shop;
use App\Models\User;
use App\Models\City;
use App\Models\DistributorCity;

class ShopController extends BaseController
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
    public function index(Request $request)
    {
		$search_key = $request->input('search_key','');
		$distributor_id = $request->input('distributor_id','');
		$distributor_shop_ids = DistributorShop::where('distributor_id',$distributor_id)->pluck('shop_id')->toArray();
        if($distributor_id)
        {
            Distributor::where('id',$distributor_id)->increment('qrcode_count');
        }
        $city_code = $request->input('city_code',Auth::user()->city_code);
		$city = City::where('city_code',$city_code)->first()->toArray();
		User::where('openid',Auth::user()->openid)->update([
			'city_code' =>$city_code,
			'city' => $city['name'],
		]);
        $shops = Shop::when($city_code,function ($query) use ($city_code) {
            return $query->where('city_code', $city_code);
        })->when($search_key,function ($query) use ($search_key) {
            return $query->where('shop_name', 'like','%'.$search_key.'%');
        })->when($distributor_shop_ids,function ($query) use ($distributor_shop_ids) {
            return $query->whereIn('id', $distributor_shop_ids);
        })
        ->orderBy('id','desc')
        ->paginate(20);

		$latitude = Auth::user()->latitude;
		$longitude = Auth::user()->longitude;
        $shops_data = $shops->toArray()['data'];
		foreach($shops_data as $key => $shop)
		{
			$shops_data[$key]['distance'] = $latitude ? get_distance([$longitude,$latitude],[$shop['longitude'],$shop['latitude']]) : '未知';
		}
		
        if ($this->response->typeIs('json')) {

            if($shops->count())
            {
                $data['content'] = $this->response->layout('render')
                    ->view('shop.list')
                    ->data(compact('shops_data'))->render()->getContent();
                return $this->response
                    ->success()
                    ->data($data)
                    ->output();
            }
            return $this->response
                ->success()
                ->data('')
                ->output();
        }
        return $this->response->title('门店')
            ->data(compact('shops_data','city','search_key'))
            ->view('shop.index')
            ->output();
    }
    public function show(Request $request,Shop $shop)
    {
		$latitude = Auth::user()->latitude;
		$longitude = Auth::user()->longitude;
        $shop->images = explode(',',$shop->images);
		$shop->distance = $latitude ? get_distance([$longitude,$latitude],[$shop['longitude'],$shop['latitude']]) : '未知';
		
        return $this->response->title('门店')
            ->data(compact('shop'))
            ->view('shop.show')
            ->output();
    }
}
