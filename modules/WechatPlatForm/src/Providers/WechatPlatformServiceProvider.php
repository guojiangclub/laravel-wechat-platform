<?php

namespace iBrand\Wechat\Platform\Providers;

use Illuminate\Support\ServiceProvider;

class WechatPlatformServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'wechat-platform');

        if ($this->app->runningInConsole()) {

            // $this->publishes([
            //     __DIR__ . '/../../resources/assets' => public_path('assets'),
            // ], 'wechat-platform-assets');


            $this->publishes([
                __DIR__ . '/../config.php' => config_path('wechat-platform.php'),
            ]);


            return $this->loadMigrationsFrom(__DIR__.'/../../migrations');

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(
            __DIR__ . '/../config.php', 'wechat-platform'
        );
    }
}
