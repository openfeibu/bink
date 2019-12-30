<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\ShopCategoryRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class ShopCategoryRepository extends BaseRepository implements ShopCategoryRepositoryInterface
{

    /**
     * Booting the repository.
     *
     * @return null
     */
    public function boot()
    {
        $this->fieldSearchable = config('model.shop.shop_category.search');
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return config('model.shop.shop_category.model');
    }

}
