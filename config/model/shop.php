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
        'fillable'      => ['shop_name','image', 'images','address', 'city_code', 'city_name', 'opening_time', 'closing_time', 'content', 'longitude', 'latitude','view_count', 'created_at', 'updated_at'],
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
