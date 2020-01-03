<?php

return [
    /*
     * Package.
     */
    'package'  => 'report',

    /*
     * Modules.
     */
    'modules'  => ['report'],

    'policies' => [

    ],

    'report'     => [
        'model'         => \App\Models\Report::class,
        'table'         => 'reports',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['tel','user_id', 'shop_id','shop_name','content', 'created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/report',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'report_name'        => 'like',
        ],
    ],
    'report_category'     => [
        'model'         => \App\Models\ReportCategory::class,
        'table'         => 'report_categories',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['name','created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/report',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'report_name'        => 'like',
        ],
    ],
    'report_report_category'     => [
        'model'         => \App\Models\ReportReportCategory::class,
        'table'         => 'report_report_category',
        //'presenter'     => \Litepie\User\Repositories\Presenter\UserPresenter::class,
        'hidden'        => [],
        'visible'       => [],
        'guarded'       => ['*'],
        'slugs'         => [],
        'dates'         => ['created_at', 'updated_at'],
        'appends'       => [],
        'fillable'      => ['report_id','report_category_id', 'created_at', 'updated_at'],
        'translate'     => [],

        'upload_folder' => '/report',
        'casts'         => [

        ],
        'revision'      => [],
        'perPage'       => '20',
        'search'        => [
            'report_name'        => 'like',
        ],
    ],
  
];
