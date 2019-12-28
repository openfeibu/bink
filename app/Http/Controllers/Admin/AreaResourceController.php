<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Models\Area;
use App\Repositories\Eloquent\AreaRepository;
use Illuminate\Http\Request;

class AreaResourceController extends BaseController
{
    public function __construct(AreaRepository $areaRepository)
    {
        parent::__construct();
        $this->repository = $areaRepository;
    }
   public function getList(Request $request)
   {
       $parent_code = $request->get('parent_code');

       $cities = $this->repository->getList($parent_code);

       return $this->response
           ->success()
           ->count($cities->count())
           ->data($cities->toArray())
           ->json();
   }
}
