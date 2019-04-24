<?php

/*
 * This file is part of ibrand/wechat-platform.
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
 * 获取小程序码
 * Class AppCodeController.
 */
class AppCodeController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    )
    {
        $this->platform = $platformService;
    }

    /**
     * 永久有效适用于需要的码数量较少的业务场景.
     *
     * @return \EasyWeChat\Kernel\Http\StreamResponse
     *
     * @throws \Exception
     */
    public function get()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->app_code->get($data['path'], $data['optional']);

        // 返回JSON
        return $result;
    }

    /**
     * 小程序码适用于需要的码数量极多，或仅临时使用的业务场景.
     *
     * @return \EasyWeChat\Kernel\Http\StreamResponse
     *
     * @throws \Exception
     */
    public function getUnlimit()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->app_code->getUnlimit($data['scene'], $data['optional']);

        // 返回JSON
        return $result;
    }

    /**
     * 获取小程序二维码
     *
     * @return \EasyWeChat\Kernel\Http\StreamResponse
     *
     * @throws \Exception
     */
    public function getQrCode()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        $width = isset($data['width']) ? $data['width'] : null;

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->app_code->getQrCode($data['path'], $width);

        // 返回JSON
        return $result;
    }
}
