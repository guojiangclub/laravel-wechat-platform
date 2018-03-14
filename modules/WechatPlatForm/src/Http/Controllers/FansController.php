<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 粉丝.
 */
class FansController extends Controller
{

    protected $platform;

    public function __construct(
         PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 获取粉丝列表.
     */
    public function lists()
    {
        // 参数
        $appid = request('appid');

        $nextOpenId = request('nextOpenId');

        // 授权
        $server =$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user->list($nextOpenId);

        // 返回JSON
        return $result;
    }

    /**
     * 获取单个或多个粉丝信息.
     */
    public function get()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        if(!is_array($data['openid'])){
            $result = $server->user->get($data['openid']);
        }else{
            $result = $server->user->select($data['openid']);
        }
        // 返回JSON
        return $result;
    }


    /**
     * 修改粉丝备注.
     */
    public function remark()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口

        $result = $server->user->remark($data['openid'],$data['remark']);

        // 返回JSON
        return $result;
    }


    /**
     * 拉黑单个或多个粉丝.
     */
    public function block()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user->block($data['openid']);
        // 返回JSON
        return $result;
    }


    /**
     * 取消拉黑单个或多个粉丝.
     */
    public function unblock()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user->unblock($data['openid']);
        // 返回JSON
        return $result;
    }


    /**
     * 获取黑名单.
     */
    public function blacklist()
    {
        // 参数
        $appid = request('appid');

        $beginOpenid=request('beginOpenid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user->blacklist($beginOpenid);
        // 返回JSON
        return $result;
    }




}
