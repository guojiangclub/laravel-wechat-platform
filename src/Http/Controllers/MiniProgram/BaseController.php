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
 * 基础功能接口
 * Class BaseController.
 */
class BaseController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     *根据jsCode获取用户session 信息.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function session()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->auth->session($data['code']);

        // 返回JSON
        return $result;
    }

    /**
     * 数据统计与分析.
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
        $server = $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $form = request('form');

        $to = request('to');

        $result = $server->data_cube->$str($form, $to);

        // 返回JSON
        return $result;
    }

    /**
     * 微信小程序消息解密.
     *
     * @return array
     *
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function decryptedData()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        $result = $server->encryptor->decryptData($data['session'], $data['iv'], $data['encryptData']);

        // 返回JSON
        return $result;
    }
}
