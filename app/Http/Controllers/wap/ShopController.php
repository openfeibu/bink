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
		$distributor_id = $request->input('distributor_id',Auth::user()->distributor_id);
		$distributor_shop_ids = DistributorShop::where('distributor_id',$distributor_id)->pluck('shop_id')->toArray();

        $city_code = $request->input('city_code');
        $city_code = $city_code ? $city_code : Auth::user()->local_city_code;
		$city = City::where('city_code',$city_code)->first()->toArray();
		User::where('openid',Auth::user()->openid)->update([
			'city_code' =>$city_code,
			'city' => $city['name'],
		]);

        $latitude = Auth::user()->latitude ? Auth::user()->latitude : 0;
        $longitude = Auth::user()->longitude ? Auth::user()->longitude : 0;

        $shops = Shop::select(DB::raw("*,ROUND(  
            6371.393 * 2 * ASIN(  
                SQRT(  
                    POW(  
                        SIN(  
                            (  
                                {$latitude} * 3.1415926 / 180 - latitude * PI() / 180  
                            ) / 2  
                        ),  
                        2  
                    ) + COS({$latitude} * 3.1415926 / 180) * COS(latitude * PI() / 180) * POW(  
                        SIN(  
                            (  
                                {$longitude} * 3.1415926 / 180 - longitude * PI() / 180  
                            ) / 2  
                        ),  
                        2  
                    )  
                )  
            ) * 1000  
        ) AS distance"))
        ->when($city_code,function ($query) use ($city_code) {
            return $query->where('city_code', $city_code);
        })->when($search_key,function ($query) use ($search_key) {
            return $query->where('shop_name', 'like','%'.$search_key.'%');
        })->when($distributor_id,function ($query) use ($distributor_shop_ids) {
            return $query->whereIn('id', $distributor_shop_ids);
        })
        ->orderBy('distance','asc')
        ->orderBy('id','desc')
        ->paginate(20);


        $shops_data = $shops->toArray()['data'];

		foreach($shops_data as $key => $shop)
		{
			//$shops_data[$key]['distance'] = $latitude ? get_distance([$longitude,$latitude],[$shop['longitude'],$shop['latitude']]) : '未知';
            $shops_data[$key]['distance'] = $latitude ? to_km($shop['distance']) : '未知';
		}

        if ($this->response->typeIs('json')) {

            $data = [];
            if($shops->count())
            {
                $data['content'] = $this->response->layout('render')
                    ->data(compact('shops_data'))
                    ->view('shop.list')
                    ->render()
                    ->getContent();

                return $this->response
                    ->success()
                    ->data($shops_data)
                    ->output();
            }
            return $this->response
                ->success()
                ->data($shops_data)
                ->output();
        }
        return $this->response->title('门店')
            ->data(compact('shops_data','city','search_key','city_code'))
            ->view('shop.index')
            ->output();
    }
    public function show(Request $request,Shop $shop)
    {
		$latitude = Auth::user()->latitude;
		$longitude = Auth::user()->longitude;
        $shop->images = explode(',',$shop->images);
		$shop->distance = $latitude ? get_distance([$longitude,$latitude],[$shop['longitude'],$shop['latitude']]) : '未知';

        Shop::where('id',$shop->id)->increment('view_count');
        return $this->response->title('门店')
            ->data(compact('shop'))
            ->view('shop.show')
            ->output();
    }
}
