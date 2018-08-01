<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Providers;

use iBrand\Wechat\Platform\WechatPlatFormBackend;
use Illuminate\Support\ServiceProvider;

class WechatPlatformServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        WechatPlatFormBackend::boot();

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'wechat-platform');

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__ . '/../../resources/assets' => public_path('assets'),
            // ], 'wechat-platform-assets');

            $this->publishes([
                __DIR__.'/../config.php' => config_path('wechat-platform.php'),
            ]);

            return $this->loadMigrationsFrom(__DIR__.'/../../migrations');
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config.php', 'wechat-platform'
        );
    }
}
