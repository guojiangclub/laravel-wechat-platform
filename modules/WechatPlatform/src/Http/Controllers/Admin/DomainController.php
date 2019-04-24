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
 * Class DomainController.
 */
class DomainController extends Controller
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
    public function index()
    {
        $appid = request('appid');

        $requestdomain = settings('requestdomain') ? settings('requestdomain') : [];

        $wsrequestdomain = settings('wsrequestdomain') ? settings('wsrequestdomain') : [];

        $uploaddomain = settings('uploaddomain') ? settings('uploaddomain') : [];

        $downloaddomain = settings('downloaddomain') ? settings('downloaddomain') : [];

        return LaravelAdmin::content(function (Content $content) use ($requestdomain, $wsrequestdomain, $uploaddomain, $downloaddomain) {
            $content->header('服务器域名设置');

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '服务器域名', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '服务器域名']
            );

            $content->body(view('wechat-platform::mini.domain.index', compact('requestdomain', 'wsrequestdomain', 'uploaddomain', 'downloaddomain')));
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $data_new = [];

        $data = request()->except('_token');

        foreach ($data as $k => $item) {
            if (is_array($item)) {
                foreach ($item as $ck => $citem) {
                    if (null != $citem) {
                        if ('wsrequestdomain' != $k) {
                            $data_new[$k][$ck] = 'https://'.$citem;
                        } else {
                            $data_new[$k][$ck] = 'wss://'.$citem;
                        }
                    }
                }
            }
        }

        $data_new['wsrequestdomain'] = isset($data_new['wsrequestdomain']) ? $data_new['wsrequestdomain'] : '';

        settings()->setSetting($data_new);

        return $this->api([], true);
    }
}
