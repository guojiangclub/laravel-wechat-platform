<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
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
use iBrand\Wechat\Platform\Models\Authorizer;
use iBrand\Wechat\Platform\Models\Clients;
use iBrand\Wechat\Platform\Repositories\AuthorizerRepository;
use iBrand\Wechat\Platform\Services\CodeTemplateService;

/**
 * Class WechatController.
 */
class WechatController extends Controller
{
    protected $authorizerRepository;

    protected $codeTemplateService;

    public function __construct(AuthorizerRepository $authorizerRepository, CodeTemplateService $codeTemplateService)
    {
        $this->authorizerRepository = $authorizerRepository;

        $this->codeTemplateService = $codeTemplateService;
    }

    /**
     * @return Content
     */
    public function index()
    {
        $template_list = [];

        $customers = Clients::all();

        $type = request('type');

        if (2 == $type) {
            $template_list_arr = $this->codeTemplateService->getCodeTemplateList();

            if (isset($template_list_arr['template_list'])) {
                $template_list = $template_list_arr['template_list'];
            }
        }

        $limit = request('limit') ? request('limit') : 20;

        $lists = $this->authorizerRepository->getAuthorizerList(request('type'), request('client_id'), request('appid'), $limit);

        $name = 1 == $type ? '公众号' : '小程序';

        return LaravelAdmin::content(function (Content $content) use ($lists, $customers, $name, $type, $template_list) {
            $content->header($name.'管理');

            $content->breadcrumb(
                ['text' => $name.'管理', 'url' => 'wechat?type='.$type, 'no-pjax' => 1],
                ['text' => $name.'列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => $name.'列表']
            );

            $content->body(view('wechat-platform::wechat.index', compact('lists', 'customers', 'name', 'type', 'template_list')));
        });
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($info = Authorizer::find($id)) {
            $info->client_id = 0;
            $info->save();

            return $this->api([], true);
        }

        return $this->api([], false, 400, '删除失败');
    }
}
