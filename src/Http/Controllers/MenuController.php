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

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 菜单.
 * Class MenuController.
 */
class MenuController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 查询已设置菜单.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getAll()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->menu->list();

        // 返回JSON
        return $result;
    }

    /**
     * 获取当前菜单.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getCurrent()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->menu->current();

        // 返回JSON
        return $result;
    }

    /**
     * 添加菜单(包括个性化菜单).
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
        if (isset($data['matchRule']) && !empty($data['matchRule'])) {
            $result = $server->menu->create($data['buttons'], $data['matchRule']);
        } else {
            $result = $server->menu->create($data['buttons']);
        }

        // 返回JSON
        return $result;
    }

    /**
     * 删除菜单.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function delMenu()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        if (isset($data['menuid']) and !empty($data['menuid'])) {
            $result = $server->menu->delete($data['menuid']);
        } else {
            $result = $server->menu->delete();
        }
        // 返回JSON
        return $result;
    }

    /**
     * 测试个性化菜单.
     *$userId 可以是粉丝的 OpenID，也可以是粉丝的微信号。
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function match()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->menu->match($data['userid']);
        // 返回JSON
        return $result;
    }
}
