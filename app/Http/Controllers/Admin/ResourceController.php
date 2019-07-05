<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Distributor;
use App\Models\Shop;
use App\Models\User;
use Route;
use App\Http\Controllers\Admin\Controller as BaseController;
use App\Traits\AdminUser\AdminUserPages;
use App\Http\Response\ResourceResponse;
use App\Traits\Theme\ThemeAndViews;
use App\Traits\AdminUser\RoutesAndGuards;

class ResourceController extends BaseController
{
    use AdminUserPages,ThemeAndViews,RoutesAndGuards;

    public function __construct()
    {
        parent::__construct();
        if (!empty(app('auth')->getDefaultDriver())) {
            $this->middleware('auth:' . app('auth')->getDefaultDriver());
           // $this->middleware('role:' . $this->getGuardRoute());
            $this->middleware('permission:' .Route::currentRouteName());
            $this->middleware('active');
        }
        $this->response = app(ResourceResponse::class);
        $this->setTheme();
    }
    /**
     * Show dashboard for each user.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $today_user_count = User::where('created_at','>',date('Y-m-d 00:00:00'))->count();
        $user_count = User::count();
        $shop_count = Shop::count();
        $distributor_count = Distributor::count();
        return $this->response->title(trans('app.name'))
            ->data(compact('user_count','shop_count','distributor_count','today_user_count'))
            ->view('home')
            ->output();
    }
    public function dashboard()
    {
        return $this->response->title('测试')
            ->view('dashboard')
            ->output();
    }
    public function cityJson()
    {
        exit;
        $letters = config('common.letter');
        $data = [];
        foreach ($letters as $letter)
        {
            $cities = City::where('letter',$letter)->orderBy('letter','asc')->get()->toArray();
            foreach ($cities as $city)
            {
                $data[$letter][]['city'] = [
                    'name' => $city['name'],
                    'code' => $city['city_code'],
                ];
            }
        }
        file_put_contents('js/city.json', json_encode($data));
    }
}
