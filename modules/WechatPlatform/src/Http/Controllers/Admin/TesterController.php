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
use iBrand\Wechat\Platform\Repositories\TesterRepository;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * Class TesterController.
 */
class TesterController extends Controller
{
    protected $platformService;

    protected $errcode;

    protected $testerRepository;

    public function __construct(
        PlatformService $platformService, TesterRepository $testerRepository
    ) {
        $this->platformService = $platformService;

        $this->errcode = config('mini_program_errcode');

        $this->testerRepository = $testerRepository;
    }

    /**
     * @return Content
     */
    public function getLists()
    {
        $lists = [];

        $appid = request('appid');

        $lists = $this->testerRepository->getListByAppId($appid);

        return LaravelAdmin::content(function (Content $content) use ($lists, $appid) {
            $content->header('体验微信管理');

            $content->description($appid);

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '体验微信管理', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序列表']
            );

            $content->body(view('wechat-platform::mini.tester.index', compact('lists')));
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $appid = request('appid');

        $wechatid = request('wechatid');

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $this->api([], false, 400, '该小程序不存在');
        }

        $info = $this->testerRepository->getTesterByWechatId($appid, $wechatid);

        if ($info) {
            return $this->api([], false, 400, '体验者已经存在');
        }

        $res = $server->tester->bind($wechatid);

        if ((isset($res['errcode']) and 85004 == $res['errcode']) || 0 == $res['errcode']) {
            $this->testerRepository->ensureTester($appid, $wechatid);

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

        $res = $server->tester->unbind($id);

        if (isset($res['errcode']) and 0 == $res['errcode']) {
            $this->testerRepository->deleteWhere(['appid' => $appid, 'wechatid' => $id]);

            return $this->api([], true);
        }

        return $this->admin_wechat_api($res);
    }
}
