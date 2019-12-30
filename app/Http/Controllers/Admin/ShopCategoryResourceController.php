<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ResourceController as BaseController;
use App\Repositories\Eloquent\ShopCategoryRepository;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Tree;
/**
 * Resource controller class for page.
 */
class ShopCategoryResourceController extends BaseController
{
    /**
     * Initialize category resource controller.
     *
     * @param type ShopCategoryRepository $shop_category
     *
     */
    public function __construct(ShopCategoryRepository $shop_category)
    {
        parent::__construct();
        $this->repository = $shop_category;
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
        return $this->response->title(trans('category.name'))
            ->view('shop.category.index', true)
            ->output();
    }
    public function store(Request $request)
    {
        try {
            $attributes = $request->all();

            $page = $this->repository->create($attributes);

            return $this->response->message(trans('messages.success.created', ['Module' => trans('category.name')]))
                ->success()
                ->url(guard_url('shop_category'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('shop_category'))
                ->redirect();
        }
    }
    public function update(Request $request,ShopCategory $shop_category)
    {
        try {
            $attributes = $request->all();
            $shop_category->update($attributes);
            
            return $this->response->message(trans('messages.success.updated', ['Module' => trans('category.name')]))
                ->success()
                ->url(guard_url('shop_category'))
                ->redirect();
        } catch (Exception $e) {
            return $this->response->message($e->getMessage())
                ->code(400)
                ->status('error')
                ->url(guard_url('shop_category'))
                ->redirect();
        }
    }
    public function destroy(Request $request,ShopCategory $shop_category)
    {
        try {
            $this->repository->forceDelete([$shop_category->id]);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('category.name')]))
                ->success()
                ->url(guard_url('shop_category'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('shop_category'))
                ->redirect();
        }
    }
    public function destroyAll(Request $request)
    {
        try {
            $data = $request->all();
            $ids = $data['ids'];
            $this->repository->forceDelete($ids);

            return $this->response->message(trans('messages.success.deleted', ['Module' => trans('category.name')]))
                ->success()
                ->url(guard_url('shop_category'))
                ->redirect();

        } catch (Exception $e) {

            return $this->response->message($e->getMessage())
                ->status("error")
                ->code(400)
                ->url(guard_url('shop_category'))
                ->redirect();
        }
    }
}