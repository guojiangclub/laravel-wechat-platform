<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    /*
     * 开放平台第三方平台
     */
    'open_platform' => [
        'default' => [
            'app_id' => env('WECHAT_OPEN_PLATFORM_APPID', ''),
            'secret' => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
            'token' => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
            'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),

            /*
               * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
               */
            'response_type' => 'array',

            /*
             * 使用 Laravel 的缓存系统
             */
            'use_laravel_cache' => true,

            /*
             * 日志配置
             *
             * level: 日志级别，可选为：
             *                 debug/info/notice/warning/error/critical/alert/emergency
             * file：日志文件位置(绝对路径!!!)，要求可写权限
             */
            'log' => [
                'level' => env('WECHAT_LOG_LEVEL', 'debug'),
                'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat-'.date('Y-m').'.log')),
            ],
        ],
    ],
];
