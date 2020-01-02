<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use Hashids;

class ReportListTransformer extends TransformerAbstract
{
    public function transform(\App\Models\Report $report)
    {
        return [
            'id'                => $report->id,
            'user_name'         => $report->user->name,
            'shop_id'         => $report->shop->id,
            'shop_name'         => $report->shop->shop_name,
            'tel'               => $report->tel,
            'content'             => $report->content,
            'categories_name' => implode('、',$report->categories->pluck('name')->toArray()),
            'created_at'        => format_date_time($report->created_at,'Y-m-d H:i:s'),
            'updated_at'        => format_date_time($report->updated_at,'Y-m-d H:i:s'),
        ];
    }
}