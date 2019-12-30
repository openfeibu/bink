<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\ShopActivityRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class ShopActivityRepository extends BaseRepository implements ShopActivityRepositoryInterface
{

    /**
     * Booting the repository.
     *
     * @return null
     */
    public function boot()
    {
        $this->fieldSearchable = config('model.shop.shop_activity.search');
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return config('model.shop.shop_activity.model');
    }

}
