<?php

return [
    /*
     * Package.
     */
    'package'  => 'distributor',

    /*
     * Modules.
     */
    'modules'  => ['distributor','distributor_city'],

    'policies' => [

    ],

    'distributor'     => [
        'model'         => \App\Models\Distributor::class,
        'table'         => 'distributors',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['distributor_name', 'desc','qrcode_count','created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/distributor',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'distributor_name'        => 'like',
        ],
    ],
    'distributor_city'     => [
        'model'         => \App\Models\DistributorCity::class,
        'table'         => 'distributor_cities',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['distributor_id', 'city_code'],
        'translate'     => [],

        'upload_folder' => '/distributor',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'distributor_name'        => 'like',
        ],
    ],
];
