<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use Hashids;
use App\Models\Distributor;

class DistributorListTransformer extends TransformerAbstract
{
    public function transform(Distributor $distributor)
    {
        return [
            'id'                => $distributor->id,
            'distributor_name'  => $distributor->distributor_name,
            'desc'              => $distributor->desc,
            'qrcode_count' => $distributor->qrcode_count,
            'qrcode'            => app(Distributor::class)->generateQrcode($distributor->id,$distributor->distributor_name),
            'created_at'        => format_date_time($distributor->created_at,'Y-m-d H:i:s'),
            'updated_at'        => format_date_time($distributor->updated_at,'Y-m-d H:i:s'),
        ];
    }
}