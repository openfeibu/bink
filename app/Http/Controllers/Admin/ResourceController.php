<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
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
        return $this->response->title(trans('app.name'))
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
