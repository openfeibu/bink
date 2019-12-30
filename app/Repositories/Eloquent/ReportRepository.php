<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\ReportRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Report;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{

    public function boot()
    {
        $this->fieldSearchable = config('model.report.report.search');
    }

    public function model()
    {
        return config('model.report.report.model');
    }
}