<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;
use iBrand\Wechat\Platform\Services\MessageService;



/**
 * 客服
 */
class StaffController extends Controller
{

    protected $platform;

    protected $message;

    public function __construct(

        PlatformService $platformService

        ,MessageService $messageService
    ) {

        $this->platform = $platformService;

        $this->message=$messageService;

    }


    /**
     * 获取所有客服
     */
    public function getLists()
    {

        // 参数
        $appid = request('appid');

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->list();

        // 返回JSON
        return $result;
    }


    /**
     * 获取所有在线的客服.
     */
    public function getOnLines()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->list();

        // 返回JSON
        return $result;
    }


    /**
     * 添加客服
     */
    public function store()
    {

        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result=$server->customer_service->create($data['kf_account'],$data['kf_nick']);

        // 返回JSON
        return $result;
    }

    /**
     * 修改客服
     */
    public function update()
    {

        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result=$server->customer_service->update($data['kf_account'],$data['kf_nick']);

        // 返回JSON
        return $result;
    }


    /**
     * 删除客服
     */
    public function delete()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result=$server->customer_service->delete($data['kf_account']);

        // 返回JSON
        return $result;
    }


    /**
     * 获取客服与客户聊天记录
     */
    public function messages()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result=$server->customer_service->messages($data['startTime'],$data['endTime'],$data['msgId'],$data['number']);

        // 返回JSON
        return $result;
    }

    /**
     * 设置客服头像
     */
    public function setAvatar()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        $file = request()->file('image');

        // 授权
        $server=$this->platform->authorizeAPI($appid);


        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        // 调用接口
        $result=$server->customer_service->setAvatar($data['kf_account'],'/tmp/'.$file->getClientOriginalName());

        // 返回JSON
        return $result;
    }


    /**
     * 主动发送消息给用户
     */
    public function sendMessage()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        $message=$data['message'];

         //调用接口
        if(isset($data['kf_account'])){
            $result = $server->customer_service->message($message)->from($data['kf_account'])->to($data['openid'])->send();
        }

        $result = $server->customer_service->message($message)->to($data['openid'])->send();

         //返回JSON
        return $result;
    }


    /**
     * 邀请微信用户加入客服
     */
    public function invite()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service->invite($data['kf_account'],$data['invite_wx']);

        // 返回JSON
        return $result;
    }


    /**
     * 获取客服昵称
     */
    protected function getNickName($kf_account,$appid){
        // 授权
        $server=$this->platform->authorizeAPI($appid);

        $str='';

        // 调用接口
        $result = $server->customer_service->list();

        if(count($result)>0){

            foreach ($result['kf_list'] as $item){

                if($item['kf_account']==$kf_account){

                    $str=$item['kf_nick'];
                }
            }
        }

        return $str;
    }


    /**
     * 创建会话
     */
    public function SessionCreate()
    {

        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        $res=[];
        // 调用接口
        $result =$server->customer_service_session->get($data['openid']);

        if(!isset($result->kf_account)){

            if($res= $server->customer_service_session->create($data['kf_account'],$data['openid'])){

                $rest = $server->customer_service_session->get($data['openid']);

                $data=$this->getNickName($rest['kf_account'],$appid);

                return ['nick_name'=>$data];
            }
        }

        return [];

    }

    /**
     * 关闭会话
     */
    public function SessionClose()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service_session->close($data['kf_account'],$data['openid']);

        return $result;

    }


    /**
     * 获取客服会话列表
     */

    public function customerSsessionList()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service_session->list($data['kf_account']);

        return $result;

    }


    /**
     * 获取未接入会话列表
     */

    public function customerSsessionWaiting()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->customer_service_session->waiting();

        return $result;

    }




}
