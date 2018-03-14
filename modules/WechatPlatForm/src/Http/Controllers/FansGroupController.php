<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 标签.
 */
class FansGroupController extends Controller
{

    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 获取所有标签.
     */
    public function lists()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->list();

        // 返回JSON
        return $result;
    }

    /**
     * 创建标签.
     */
    public function create()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->create($data['name']);

        // 返回JSON
        return $result;
    }

    /**
     * 修改标签信息.
     */
    public function update()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->update($data['groupid'], $data['name']);

        // 返回JSON
        return $result;
    }

    /**
     * 删除标签.
     */
    public function delete()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->delete($data['groupid']);

        // 返回JSON
        return $result;
    }

    /**
     * 移动用户到指定标签.
     */
    public function moveUsers()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->untagUsers($data['openids'],$data['formid']);

        $result = $server->user_tag->tagUsers($data['openids'],$data['toid']);

        // 返回JSON
        return $result;
    }


    /**
     * 批量为用户添加标签.
     */
    public function addUsers()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->tagUsers($data['openids'], $data['groupid']);

        // 返回JSON
        return $result;
    }


    /**
     * 批量为用户移除标签.
     */
    public function delUsers()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->untagUsers($data['openids'], $data['groupid']);

        // 返回JSON
        return $result;
    }


    /**
     * 获取标签下用户列表.
     */
    public function UserList()
    {
        // 参数
        $appid = request('appid');

        $nextOpenId = request('nextOpenId')?request('nextOpenId'):'';

        $data = request()->json()->all();

        // 授权
        $server= $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->user_tag->usersOfTag($data['groupid'],$nextOpenId);

        // 返回JSON
        return $result;
    }




}
