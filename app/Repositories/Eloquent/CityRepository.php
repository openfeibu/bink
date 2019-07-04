<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\CityRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function model()
    {
        return config('model.address.city.model');
    }
    public function getCities()
    {
        $cities = $this->model->orderBy('letter','asc')->get()->toArray();
        return $cities;
    }
}