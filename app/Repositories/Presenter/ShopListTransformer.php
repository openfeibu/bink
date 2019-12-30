<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use Hashids;

class ShopListTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Shop $shop)
    {
        return [
            'id'                => $shop->id,
            'shop_name'         => $shop->shop_name,
            'image'             => url('/image/original/'.$shop->image),
            'address'           => $shop->address,
            'city_name'         => $shop->city_name,
            'opening_time'      => $shop->opening_time,
            'closing_time'      => $shop->closing_time,
            'longitude'         => $shop->longitude,
            'latitude'          => $shop->latitude,
            'business_time'     => date('H:i',strtotime($shop['opening_time'])).' - '. date('H:i',strtotime($shop['closing_time'])) ,
            'view_count' => $shop->view_count,
            'type_desc' => $shop->type_desc,
            'tel' => $shop->tel,
            'categories_name' => implode('、',$shop->categories->pluck('name')->toArray()),
            'activities_name' => implode('、',$shop->activities->pluck('name')->toArray()),
            'created_at'        => format_date_time($shop->created_at,'Y-m-d H:i:s'),
            'updated_at'        => format_date_time($shop->updated_at,'Y-m-d H:i:s'),
        ];
    }
}