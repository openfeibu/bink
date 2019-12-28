<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\AreaRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class AreaRepository extends BaseRepository implements AreaRepositoryInterface
{
    public function model()
    {
        return config('model.address.area.model');
    }
    public function getProvinces()
    {
        $cities = $this->model->where('parent_code',100000)->orderBy('id','asc')->get();
        return $cities;
    }

    public function getList($parent_code=0)
    {
        return $this->where('parent_code',$parent_code)->orderBy('id','asc')->get();
    }
}