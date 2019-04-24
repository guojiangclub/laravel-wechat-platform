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
 * 二维码
 * Class QRCodeController.
 */
class QRCodeController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 创建临时二维码
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function storeTemporary()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        $expireSeconds = !isset($data['expire_seconds']) || empty($data['expire_seconds']) ? null : $data['expire_seconds'];

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->qrcode->temporary($data['scene_id'], $expireSeconds);

        if (isset($result['ticket']) and !empty($result['ticket'])) {
            $res = $server->qrcode->url($result['ticket']);

            $result['qr_code_url'] = $res;

            return $result;
        }
        // 返回JSON
        return $result;
    }

    /**
     * 创建永久二维码
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function storeForever()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->qrcode->forever($data['scene_id']);

        if (isset($result['ticket']) and !empty($result['ticket'])) {
            $res = $server->qrcode->url($result['ticket']);

            $result['qr_code_url'] = $res;

            return $result;
        }

        // 返回JSON
        return $result;
    }

    /**
     * 获取二维码网址
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getUrl()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();
        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->qrcode->url($data['ticket']);

        // 返回JSON
        return $result;
    }
}
