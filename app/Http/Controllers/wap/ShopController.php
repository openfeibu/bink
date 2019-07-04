<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use Route,Auth;
use App\Http\Controllers\Wap\Controller as BaseController;
use App\Models\Shop;
use App\Models\User;
use App\Models\City;

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
        $city_code = $request->input('city_code',Auth::user()->city_code);
		$city = City::where('city_code',$city_code)->first();
		User::where('openid',Auth::user()->openid)->update([
			'city_code' =>$city_code,
			'city' => $city->name,
		]);
        $shops = Shop::when($city_code,function ($query) use ($city_code) {
            return $query->where('city_code', $city_code);
        })
        ->orderBy('id','desc')
        ->paginate(20);

        $shops_data = $shops->toArray()['data'];

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
            ->data(compact('shops_data','city'))
            ->view('shop.index')
            ->output();
    }
    public function show(Request $request,Shop $shop)
    {
        $shop->images = explode(',',$shop->images);
        return $this->response->title('门店')
            ->data(compact('shop'))
            ->view('shop.show')
            ->output();
    }
}
