<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Repositories\Eloquent\ShopActivityRepository;
use App\Models\ShopActivity;
use Illuminate\Http\Request;
use Tree;
/**
 * Resource controller class for page.
 */
class ShopActivityResourceController extends BaseController
{
    /**
     * Initialize activity resource controller.
     *
     * @param type ShopActivityRepository $shop_activity
     *
     */
    public function __construct(ShopActivityRepository $shop_activity)
    {
        parent::__construct();
        $this->repository = $shop_activity;
        $this->repository
            ->pushCriteria(\App\Repositories\Criteria\RequestCriteria::class);
    }
    public function index(Request $request)
    {
        if ($this->response->typeIs('json'))
        {
            $categories = $this->repository
                ->orderBy('id','asc')
                ->all()
                ->toArray();
            return $this->response
                ->success()
                ->data($categories)
                ->output();
        }
        return $this->response->title(trans('activity.name'))
            ->view('shop.activity.index', true)
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $page = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('activity.name')]))
                ->success()
                ->url(guard_url('shop_activity'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('shop_activity'))
                ->redirect();
        }
    }
    public function update(Request $request,ShopActivity $shop_activity)
    {
        try {
            $attributes = $request->all();
            $shop_activity->update($attributes);
            return $this->response->message(trans('messages.success.updated', ['Module' => trans('activity.name')]))
                ->success()
                ->url(guard_url('shop_activity'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('shop_activity'))
                ->redirect();
        }
    }
    public function destroy(Request $request,ShopActivity $shop_activity)
    {
        try {
            $this->repository->forceDelete([$shop_activity->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('activity.name')]))
                ->success()
                ->url(guard_url('shop_activity'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('shop_activity'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('activity.name')]))
                ->success()
                ->url(guard_url('shop_activity'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('shop_activity'))
                ->redirect();
        }
    }
}