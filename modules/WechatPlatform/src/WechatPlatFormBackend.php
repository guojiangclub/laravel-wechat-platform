<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use iBrand\Wechat\Platform\Seeds\WechatPlatFormBackendTablesSeeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class WechatPlatFormBackend.
 */
class WechatPlatFormBackend extends Extension
{
    /**
     * Bootstrap this package.
     */
    public static function boot()
    {
        Admin::extend('ibrand-wechat-platform-backend', __CLASS__);
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        Artisan::call('db:seed', ['--class' => WechatPlatFormBackendTablesSeeder::class]);
    }
}
