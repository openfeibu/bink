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
            'created_at'        => format_date($shop->created_at),
            'updated_at'        => format_date($shop->updated_at),
        ];
    }
}