<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers\Admin;

use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use iBrand\Wechat\Platform\Http\Controllers\Controller;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * Class PluginController.
 */
class PluginController extends Controller
{
    protected $platformService;

    protected $errcode;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platformService = $platformService;

        $this->errcode = config('mini_program_errcode');

    }

    /**
     * @return Content
     */
    public function getLists()

    {

        $lists=[];

        $appid = request('appid');

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $this->api([], false, 400, '该小程序不存在');
        }

        $res = $server->plugin->list();

        if ((isset($res['errcode']) and 0 != $res['errcode'])) {

            admin_toastr('获取小程序插件失败,请授权相关接口权限', 'warning');

            return redirect()->route('admin.wechat.list', ['type' => 2]);
        }

        if (isset($res['plugin_list'])) {

            $lists=$res['plugin_list'];
        }

        return LaravelAdmin::content(function (Content $content) use ($lists, $appid) {

            $content->header('小程序插件管理');

            $content->description($appid);

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序插件管理', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序列表']
            );

            $content->body(view('wechat-platform::mini.plugin.index', compact('lists')));
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $appid = request('appid');

        $plugin_appid = request('plugin_appid');

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $this->api([], false, 400, '该小程序不存在');
        }

        $res = $server->plugin->apply($plugin_appid);

        if (isset($res['errcode']) and 0 == $res['errcode']) {

            return $this->api([], true);
        }

        return $this->admin_wechat_api($res);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $appid = request('appid');

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $this->api([], false, 400, '该小程序不存在');
        }

        $res = $server->plugin->unbind($id);

        if (isset($res['errcode']) and 0 == $res['errcode']) {

            return $this->api([], true);
        }

        return $this->admin_wechat_api($res);
    }
}
