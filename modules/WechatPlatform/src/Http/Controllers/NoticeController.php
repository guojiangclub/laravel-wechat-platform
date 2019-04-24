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
 * 模板消息.
 * Class NoticeController.
 */
class NoticeController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 获取支持的行业列表.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function getIndustry()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->getIndustry();

        // 返回JSON
        return $result;
    }

    /**
     * 添加模板
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function addTemplate()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->addTemplate($data['shortId']);

        // 返回JSON
        return $result;
    }

    /**
     * 获取所有模板列表.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function getTemplateAll()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->getPrivateTemplates();

        // 返回JSON
        return $result;
    }

    /**
     * 发送模板消息.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function send()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->send($data);

        // 返回JSON
        return $result;
    }

    /**
     * 发送一次性订阅消息.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function sendSubscription()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->sendSubscription($data);

        // 返回JSON
        return $result;
    }

    /**
     * 删除模板.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function delete()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $data = request()->json()->all();

        // 调用接口
        $result = $server->template_message->deletePrivateTemplate($data['templateid']);

        // 返回JSON
        return $result;
    }

    /**
     * 多用户发送模板消息.
     *
     * @return array|bool
     *
     * @throws \Exception
     */
    public function sendAll()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $error = [];

        $i = 0;

        if (isset($data['touser']) && is_array($data['touser'])) {
            if (count($data['touser']) > 100) {
                return false;
            }
            $tousers = $data['touser'];
            foreach ($tousers as $item) {
                $data['touser'] = $item;
                // 调用接口
                try {
                    $res=$server->template_message->send($data);

                    if(isset($res['errcode'])&&$res['errcode']==0){
                        ++$i;
                    }else{
                        $error[] = $data['touser'];
                    }

                } catch (\Exception $e) {
                    $error[] = $data['touser'];
                }
            }
        }

        return ['success_num' => $i, 'error' => $error];
    }
}
