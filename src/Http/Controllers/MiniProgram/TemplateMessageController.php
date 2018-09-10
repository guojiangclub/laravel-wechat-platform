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
 * 小程序模板消息设置
 * Class TemplateMessageController.
 */
class TemplateMessageController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     *获取小程序模板消息库标题列表.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function list()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->template_message->list($data['offset'], $data['count']);

        // 返回JSON
        return $result;
    }

    /**
     * 获取模板库某个模板标题下关键词库.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
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
        $result = $server->template_message->get($data['id']);

        // 返回JSON
        return $result;
    }

    /**
     *组合模板并添加至帐号下的个人模板库.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function add()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->template_message->add($data['id'], $data['keyword_id_list']);

        // 返回JSON
        return $result;
    }

    /**
     *删除帐号下的某个模板
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function delete()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->template_message->delete($data['template_id']);

        // 返回JSON
        return $result;
    }

    /**
     *获取帐号下已存在的模板列表.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \Exception
     */
    public function getTemplates()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->template_message->getTemplates($data['offset'], $data['count']);

        // 返回JSON
        return $result;
    }

    /**
     * 发送小程序模板消息.
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
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->template_message->send($data);

        // 返回JSON
        return $result;
    }
}
