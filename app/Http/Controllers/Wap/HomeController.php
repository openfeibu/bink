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
use App\Models\ShopActivity;
use App\Models\ShopCategory;

class HomeController extends BaseController
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
    public function home(Request $request)
    {
        $distributor_id = $request->input('distributor_id','');
        if($distributor_id)
        {
            Distributor::where('id',$distributor_id)->increment('qrcode_count');
        }
        $url_parameters = $request->all();
        if(!count($url_parameters) || (isset($url_parameters['from']) && $url_parameters['from']=='all'))
        {
            User::where('openid',Auth::user()->openid)->update([
                'distributor_id' => '',
            ]);
        }
        $search_key = $request->input('search_key','');
        $shop_type = $request->input('type','');
        $activities = $request->input('activities',[]);
        $categories = $request->input('categories',[]);

        $distributor_shop_ids = DistributorShop::where('distributor_id',$distributor_id)->pluck('shop_id')->toArray();

        $city_code = $request->input('city_code');
        $city_code = $city_code ? $city_code : Auth::user()->local_city_code;
        //$city = City::where('city_code',$city_code)->first()->toArray();
        $area = Area::where('code',$city_code)->first();

        if($area->level_type == 2)
        {
            User::where('openid',Auth::user()->openid)->update([
                'city_code' =>$city_code,
                'city' => $area->name,
            ]);
        }

        $latitude = Auth::user()->latitude ? Auth::user()->latitude : 0;
        $longitude = Auth::user()->longitude ? Auth::user()->longitude : 0;


        if ($this->response->typeIs('json')) {
            $shops = Shop::select(DB::raw("shops.*,ROUND(  
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
                ) AS distance,shop_shop_category.shop_category_id,shop_shop_activity.shop_activity_id"))
                ->leftJoin('shop_shop_category','shops.id','=','shop_shop_category.shop_id')
                ->leftJoin('shop_shop_activity','shops.id','=','shop_shop_activity.shop_id')
                ->when($area,function ($query) use ($area) {
                    if($area->level_type == 1){
                        return $query->where('province_code', $area->code);
                    }else if($area->level_type == 2){
                        return $query->where('city_code', $area->code);
                    }else if($area->level_type == 3){
                        return $query->where('county_code', $area->code);
                    }
                })->when($search_key,function ($query) use ($search_key) {
                    return $query->where('shop_name', 'like','%'.$search_key.'%');
                })->when($shop_type,function ($query) use ($shop_type) {
                    return $query->where('type', $shop_type);
                })->when($categories,function ($query) use ($categories) {
                    return $query->whereIn('shop_shop_category.shop_category_id', $categories);
                })->when($activities,function ($query) use ($activities) {
                    return $query->whereIn('shop_shop_activity.shop_activity_id', $activities);
                })->when($distributor_id,function ($query) use ($distributor_shop_ids) {
                    return $query->whereIn('id', $distributor_shop_ids);
                })
                ->groupBy('shops.id')
                ->orderBy('distance','asc')
                ->orderBy('shops.id','desc')
                ->paginate(20);


            $shops_data = $shops->toArray()['data'];

            foreach($shops_data as $key => $shop)
            {
                $shops_data[$key]['distance'] = $latitude ? to_km($shop['distance']) : '未知';
            }

            return $this->response
                ->success()
                ->data($shops_data)
                ->output();
        }
        $categories = ShopCategory::orderBy('id','asc')->get();
        $activities = ShopActivity::orderBy('id','asc')->get();

        return $this->response->title('门店')
            ->data(compact('city','search_key','city_code','distributor_id','categories','activities'))
            ->view('shop.index')
            ->output();

    }

}
