<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * JSSDK.
 * Class JsController.
 */
class JsController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * @return array|null
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function ticket()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->jssdk->getTicket();

        //返回json
        return $result;
    }

    /**
     * @return mixed
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function config()
    {
        // 参数
        $appid = request('appid');
        // 授权
        $server = $this->platform->authorizeAPI($appid);
        //调用接口
        if (empty(request('url'))) {
            $result = $server->jssdk;
        } else {
            $result = $server->jssdk->setUrl(request('url'));
        }
        if ($method = request('method') and is_array($method)) {
            return json_decode($result->buildConfig($method), true);
        }

        return json_decode($result->buildConfig([]), true);
    }
}
