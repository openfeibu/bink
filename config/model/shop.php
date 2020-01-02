<?php

return [
    /*
     * Package.
     */
    'package'  => 'shop',

    /*
     * Modules.
     */
    'modules'  => ['shop'],

    'policies' => [

    ],

    'shop'     => [
        'model'         => \App\Models\Shop::class,
        'table'         => 'shops',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['shop_name','image', 'images','address', 'city_code', 'city_name', 'province_code', 'province_name', 'county_code', 'county_name','opening_time', 'closing_time', 'content', 'longitude', 'latitude','view_count','type','tel', 'created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'shop_name'        => 'like',
//            'province_code' => '=',
//            'city_code' => '=',
//            'county_code' => '=',
            'type' => '=',
        ],
    ],
    'shop_category'     => [
        'model'         => \App\Models\ShopCategory::class,
        'table'         => 'shop_categories',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['name', 'type','created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'shop_name'        => 'like',
        ],
    ],
    'shop_shop_category'     => [
        'model'         => \App\Models\ShopShopCategory::class,
        'table'         => 'shop_shop_category',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['shop_id','shop_category_id', 'created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'shop_name'        => 'like',
        ],
    ],
    'shop_activity'     => [
        'model'         => \App\Models\ShopActivity::class,
        'table'         => 'shop_activities',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['name', 'created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'shop_name'        => 'like',
        ],
    ],
    'shop_shop_activity'     => [
        'model'         => \App\Models\ShopShopActivity::class,
        'table'         => 'shop_shop_activity',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['shop_id','shop_activity_id', 'created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'shop_name'        => 'like',
        ],
    ],
];
