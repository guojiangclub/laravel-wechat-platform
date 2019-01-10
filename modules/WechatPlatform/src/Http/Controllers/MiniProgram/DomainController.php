<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers\MiniProgram;

use iBrand\Wechat\Platform\Http\Controllers\Controller;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 修改服务器地址
 * Class DomainController.
 */
class DomainController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 设置小程序服务器域名.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function modify()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->domain->modify($data);

        // 返回JSON
        return $result;
    }

    /**
     * 设置小程序业务域名（仅供第三方代小程序调用）.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function setWebviewDomain()
    {
        // 参数
        $appid = request('appid');

        $action = 'add';

        $data = request()->json()->all();

        if (isset($data['action'])) {
            $action = $data['action'];
            unset($data['action']);
        }

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->domain->setWebviewDomain($data, $action);

        // 返回JSON
        return $result;
    }
}
