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

use iBrand\Wechat\Platform\Services\MessageService;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 客服
 * Class StaffController.
 */
class StaffController extends Controller
{
    protected $platform;

    protected $message;

    public function __construct(
        PlatformService $platformService, MessageService $messageService
    ) {
        $this->platform = $platformService;

        $this->message = $messageService;
    }

    /**
     * 获取所有客服.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getLists()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->list();

        // 返回JSON
        return $result;
    }

    /**
     * 获取所有在线的客服.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getOnLines()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->online();

        // 返回JSON
        return $result;
    }

    /**
     * 添加客服.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function store()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->create($data['kf_account'], $data['kf_nick']);

        // 返回JSON
        return $result;
    }

    /**
     * 修改客服.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function update()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->update($data['kf_account'], $data['kf_nick']);

        // 返回JSON
        return $result;
    }

    /**
     * 删除客服.
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
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->delete($data['kf_account']);

        // 返回JSON
        return $result;
    }

    /**
     * 获取客服与客户聊天记录.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function messages()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->messages($data['startTime'], $data['endTime'], $data['msgId'], $data['number']);

        // 返回JSON
        return $result;
    }

    /**
     * 设置客服头像.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function setAvatar()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        $file = request()->file('image');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        // 调用接口
        $result = $server->customer_service->setAvatar($data['kf_account'], '/tmp/'.$file->getClientOriginalName());

        // 返回JSON
        return $result;
    }

    /**
     * 主动发送消息给用户.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function sendMessage()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $message = $data['message'];

        //调用接口
        if (isset($data['kf_account'])) {
            $result = $server->customer_service->message($message)->from($data['kf_account'])->to($data['openid'])->send();
        }

        $result = $server->customer_service->message($message)->to($data['openid'])->send();

        //返回JSON
        return $result;
    }

    /**
     * 邀请微信用户加入客服.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function invite()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->invite($data['kf_account'], $data['invite_wx']);

        // 返回JSON
        return $result;
    }

    /**
     * 创建会话.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function SessionCreate()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $res = [];
        // 调用接口
        $result = $server->customer_service_session->get($data['openid']);

        $data_new = [];

        if (!isset($result['kf_account']) || empty($result['kf_account'])) {
            $res = $server->customer_service_session->create($data['kf_account'], $data['openid']);

            if (isset($res->errmsg) and 'ok' == $res->errmsg) {
                $rest = $server->customer_service_session->get($data['openid']);

                $data_new = $this->getNickName($rest['kf_account'], $appid);
            }
        } else {
            $data_new = $this->getNickName($result['kf_account'], $appid);
        }

        return ['nick_name' => $data_new];
    }

    /**
     * 获取客服昵称.
     *
     * @param $kf_account
     * @param $appid
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getNickName($kf_account, $appid)
    {
        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $str = '';

        // 调用接口
        $result = $server->customer_service->list();

        if (count($result) > 0) {
            foreach ($result['kf_list'] as $item) {
                if ($item['kf_account'] == $kf_account) {
                    $str = $item['kf_nick'];
                }
            }
        }

        return $str;
    }

    /**
     * 关闭会话.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function SessionClose()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service_session->close($data['kf_account'], $data['openid']);

        return $result;
    }

    /**
     * 获取客服会话列表.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function customerSsessionList()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service_session->list($data['kf_account']);

        return $result;
    }

    /**
     * 获取未接入会话列表.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function customerSsessionWaiting()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service_session->waiting();

        return $result;
    }
}
