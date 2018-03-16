<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 模板消息.
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
     */
    public function getIndustry(){
        // 参数
        $appid = request('appid');

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->getIndustry();

        // 返回JSON
        return $result;
    }


    /**
     * 添加模板
     */
    public function addTemplate(){
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->addTemplate($data['shortId']);;

        // 返回JSON
        return $result;
    }


    /**
     * 获取所有模板列表.
     */
    public function getTemplateAll()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->getPrivateTemplates();

        // 返回JSON
        return $result;
    }


    /**
     * 发送模板消息.
     */
    public function send()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->template_message->send($data);

        // 返回JSON
        return $result;
    }

    /*
     * 发送一次性订阅消息
     */
     public function sendSubscription(){
         // 参数
         $appid = request('appid');

         $data = request()->json()->all();

         // 授权
         $server=$this->platform->authorizeAPI($appid);

         // 调用接口
         $result = $server->template_message->sendSubscription($data);

         // 返回JSON
         return $result;
     }


    /**
     * 删除模板.
     */
    public function delete()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        $data = request()->json()->all();

        // 调用接口
        $result = $server->template_message->deletePrivateTemplate($data['templateid']);

        // 返回JSON
        return $result;
    }


    /**
     * 多用户发送模板消息
     */
    public function sendAll()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

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
                    $server->template_message->send($data);
                    $i++;
                } catch (\Exception $e) {
                    $error[] = $data['touser'];
                }
            }
        }

        return ['success_num'=>$i, 'error'=>$error];
    }
}