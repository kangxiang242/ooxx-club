<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',


    'resizes'=>[
        /**
         * 商品列表图
         */
        'goods'=>[
            '40','80','200','262'
        ],

        /**
         * 商品详情
         */
        'goods-desc'=>[
            '28','68',
        ],
    ],

];
