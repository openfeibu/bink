<?php

return [
    /*
     * Package.
     */
    'package'  => 'address',

    /*
     * Modules.
     */
    'modules'  => ['city','province'],

    'policies' => [

    ],

    'province'     => [
        'model'         => \App\Models\Province::class,
        'table'         => 'provinces',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => [],
        'appends'       => [],
        'fillable'      => ['name', 'province_code','letter'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'uploads'       => [
            'images' => [
                'count' => 1,
                'type'  => 'image',
            ],
        ],
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'name'        => 'like',
        ],
    ],
    'city'     => [
        'model'         => \App\Models\City::class,
        'table'         => 'cities',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => [],
        'appends'       => [],
        'fillable'      => ['name', 'province_code', 'city_code','letter'],
        'translate'     => [],

        'upload_folder' => '/shop',
        'uploads'       => [
            'images' => [
                'count' => 1,
                'type'  => 'image',
            ],
        ],
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'name'        => 'like',
        ],
    ],
];
