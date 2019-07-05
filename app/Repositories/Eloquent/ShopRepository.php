<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\ShopRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Province;
use App\Models\City;
use App\Models\Shop;

class ShopRepository extends BaseRepository implements ShopRepositoryInterface
{

    public function boot()
    {
        $this->fieldSearchable = config('model.shop.shop.search');
    }

    public function model()
    {
        return config('model.shop.shop.model');
    }
    public function getShopTree()
    {
        $provinces = Shop::join('cities','cities.city_code','=','shops.city_code')
            ->join('provinces','provinces.province_code','=','cities.province_code')
            ->groupBy('provinces.province_code')
            ->orderBy('provinces.letter')
            ->select('provinces.province_code','provinces.name')
            ->get()
            ->toArray();

        $cities = Shop::join('cities','cities.city_code','=','shops.city_code')
            ->join('provinces','provinces.province_code','=','cities.province_code')
            ->groupBy('cities.city_code')
            ->orderBy('cities.letter')
            ->select('provinces.province_code','cities.city_code','cities.name')
            ->get()
            ->toArray();

        $shops = Shop::join('cities','cities.city_code','=','shops.city_code')
            ->join('provinces','provinces.province_code','=','cities.province_code')
            ->get()
            ->toArray();
        $data = [];
        foreach($provinces as $province_key => $province)
        {
            $data[$province['province_code']] = $province;
            foreach($cities as $city_key => $city)
            {
                if($city['province_code'] == $province['province_code'])
                {
                    $data[$province['province_code']]['cities'][$city['city_code']] = $city;
                    $shops = Shop::where('city_code','=',$city['city_code'])
                        ->get()
                        ->toArray();
                    $data[$province['province_code']]['cities'][$city['city_code']]['shops'] = $shops;
                }


            }
        }

        return $data;
    }
}