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
use iBrand\Wechat\Platform\Services\CodeTemplateService;
use iBrand\Wechat\Platform\Repositories\ThemeRepository;

/**
 * Class CodeTemplateController.
 */
class CodeTemplateController extends Controller
{
    protected $codeTemplateService;

    protected $errcode;

    protected $themeRepository;

    public function __construct(
        CodeTemplateService $codeTemplateService, ThemeRepository $themeRepository
    )
    {
        $this->codeTemplateService = $codeTemplateService;

        $this->themeRepository = $themeRepository;

        $this->errcode = config('mini_program_errcode');
    }

    /**
     * 获取草稿箱内的所有临时代码草稿
     *
     * @return Content
     */
    public function getLists()
    {
        $lists = [];

        $draft_list = [];

        $template_list = [];

        $type = request('type');

        $name = CodeTemplateService::DRAFT == $type ? '模板草稿箱' : '小程序模版库';

        $view = 1 == $type ? 'draft_list' : 'template_list';

        $draft_list_arr = $this->codeTemplateService->getCodeTemplateGetDrafts();

        $template_list_arr = $this->codeTemplateService->getCodeTemplateList();

        if (isset($draft_list_arr['draft_list'])) {
            $draft_list = $draft_list_arr['draft_list'];
        }

        if (isset($template_list_arr['template_list'])) {
            $template_list = $template_list_arr['template_list'];
        }

        $system_mini_master_template = settings('system_mini_master_template');

        $system_mini_dev_template = settings('system_mini_dev_template');

        $theme_list = $this->themeRepository->getlists();

        return LaravelAdmin::content(function (Content $content) use ($theme_list, $draft_list, $template_list, $name, $view, $system_mini_master_template, $system_mini_dev_template) {
            $content->header($name);

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => $name, 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序模板']
            );

            $content->body(view('wechat-platform::mini.code_template.' . $view, compact('theme_list', 'draft_list', 'template_list', 'name', 'system_mini_master_template', 'system_mini_dev_template')));
        });
    }

    /**
     * 获取代码模版库中的所有小程序代码模版.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $draft_id = request('draft_id');

        $res = $this->codeTemplateService->getCodeTemplateCreateFromDraft($draft_id);

        return $this->admin_wechat_api($res);
    }

    /**
     * 删除指定小程序代码模版.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $res = $this->codeTemplateService->deleteCodeTemplate($id);

        return $this->admin_wechat_api($res);
    }

    /**
     * 设置当前系统模板
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function settingsTemplate()
    {
        $input = request()->except('_token');

        $type = $input['type'];

        $system_mini_template_str = 'system_mini_' . $type . '_template';

        $data[$system_mini_template_str] = $input;

        settings()->setSetting($data);

        return $this->api([], true);
    }
}
