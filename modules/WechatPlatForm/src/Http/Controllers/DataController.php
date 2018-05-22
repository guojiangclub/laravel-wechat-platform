<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 *
 */
class DataController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }


    /**
     * 获取数据
     */
    public function DataCube($str)
    {

        // 参数
        $appid = request('appid');

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $form = request('form');

        $to = request('to');

        $result = $server->data_cube->$str($form,$to);

        // 返回JSON
        return $result;
    }






}
