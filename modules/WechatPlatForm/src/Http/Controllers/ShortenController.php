<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 长链接转短链接
 */
class ShortenController extends Controller
{

    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {

        $this->platform = $platformService;
    }

    /**
     * 长链接转短链接
     */
    public function shorten()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result =  $server->url->shorten($data['url']);

        // 返回JSON
        return $result;
    }
}
