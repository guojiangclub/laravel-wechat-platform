<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * Class DataController.
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
     * 获取数据.
     *
     * @param $str
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function DataCube($str)
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $form = request('form');

        $to = request('to');

        $result = $server->data_cube->$str($form, $to);

        // 返回JSON
        return $result;
    }
}
