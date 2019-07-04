<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\DistributorRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;

class DistributorRepository extends BaseRepository implements DistributorRepositoryInterface
{

    public function boot()
    {
        $this->fieldSearchable = config('model.distributor.distributor.search');
    }

    public function model()
    {
        return config('model.distributor.distributor.model');
    }
}