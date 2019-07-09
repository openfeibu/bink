<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use Hashids;

class UserTransformer extends TransformerAbstract
{
    public function transform(\App\Models\User $user)
    {
        return [
            //'id'                => $user->getRouteKey(),
            'id' => $user->id,
            'name'              => $user->name,
            'avatar'            => $user->avatar,
            'local_city'         => $user->local_city,
            'created_at'        => format_date_time($user->created_at,'Y-m-d H:i:s'),
            'updated_at'        => format_date_time($user->updated_at,'Y-m-d H:i:s'),
        ];
    }
}