<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 二维码
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
     */
    public function storeTemporary()
    {

        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        $expireSeconds = ! isset($data['expire_seconds']) || empty($data['expire_seconds']) ? null : $data['expire_seconds'];

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->qrcode->temporary($data['scene_id'], $expireSeconds);

        if (isset($result['ticket']) AND ! empty($result['ticket'])) {

            $res = $server->qrcode->url($result['ticket']);

            $result['qr_code_url'] = $res;

            return $result;
        }
        // 返回JSON
        return $result;
    }

    /**
     * 创建永久二维码
     */
    public function storeForever()
    {

        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->qrcode->forever($data['scene_id']);

        if (isset($result['ticket']) AND ! empty($result['ticket'])) {

            $res = $server->qrcode->url($result['ticket']);

            $result['qr_code_url'] = $res;

            return $result;
        }

        // 返回JSON
        return $result;
    }

    /**
     * 获取二维码网址
     */
    public function getUrl()
    {

        // 参数
        $appid = request('appid');

        $data = request()->json()->all();
        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result =  $server->qrcode->url($data['ticket']);

        // 返回JSON
        return $result;
    }
}
