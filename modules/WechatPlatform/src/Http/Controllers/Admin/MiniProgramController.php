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
use iBrand\Wechat\Platform\Repositories\CodePublishRepository;
use iBrand\Wechat\Platform\Repositories\TesterRepository;
use iBrand\Wechat\Platform\Services\CodeService;
use iBrand\Wechat\Platform\Services\CodeTemplateService;
use iBrand\Wechat\Platform\Services\DomainService;
use iBrand\Wechat\Platform\Services\PlatformService;
use iBrand\Wechat\Platform\Models\CodePublish;
use iBrand\Wechat\Platform\Repositories\ThemeTemplateRepository;

/**
 * Class MiniProgramController.
 */
class MiniProgramController extends Controller
{
    protected $domainService;

    protected $testerRepository;

    protected $platformService;

    protected $codeService;

    protected $codeTemplateService;

    protected $codePublishRepository;

    protected $themeTemplateRepository;

    public function __construct(
        DomainService $domainService,

        TesterRepository $testerRepository,

        PlatformService $platformService,

        CodeService $codeService,

        CodeTemplateService $codeTemplateService,

        CodePublishRepository $codePublishRepository,

        ThemeTemplateRepository $themeTemplateRepository

    )
    {
        $this->domainService = $domainService;

        $this->testerRepository = $testerRepository;

        $this->platformService = $platformService;

        $this->codeService = $codeService;

        $this->codeTemplateService = $codeTemplateService;

        $this->codePublishRepository = $codePublishRepository;

        $this->themeTemplateRepository = $themeTemplateRepository;
    }

    /**
     * 为授权小程序设置服务器域名.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //获取小程序束服务器域名

        $data = [];

        $appid = request('appid');

        $domain = $this->domainService->action($appid);

        if (null == $domain || (isset($domain['errcode']) and 0 != $domain['errcode'])) {
            admin_toastr('获取小程序服务器域名失败', 'warning');

            return redirect()->route('admin.wechat.list', ['type' => 2]);
        }

        $local = $this->domainService->local();

        if (0 == count($local)) {
            admin_toastr('请完成服务器域名设置', 'warning');

            return redirect()->route('admin.mini.domain.index');
        }

        $filter = $this->domainService->filterDomain($domain, $local);

        if (count($filter) > 0) {
            //修改服务器域名覆盖
            $filter['action'] = 'set';

            $send_domain = $this->domainService->action($appid, $filter);

            if (null == $send_domain || (isset($send_domain['errcode']) and 0 != $send_domain['errcode'])) {
                admin_toastr('修改服务器域名失败', 'warning');

                return redirect()->route('admin.wechat.list', ['type' => 2]);
            }
        }

        //获取系统版本
        $type = request('type');

        if (!empty($type)) {
            $system_mini_template_str = 'system_mini_' . $type . '_template';

            $system_mini_template = settings($system_mini_template_str);

            if (!$system_mini_template) {
                admin_toastr('请设置系统' . request('type') . '版本', 'warning');

                return redirect()->route('admin.mini.template.lists', ['type' => 2]);
            }
        }

        $template_id = request('template_id');

        if (!empty($template_id) || $template_id==0) {
            $system_mini_template = $this->codeTemplateService->getCodeTemplateByTemplateID($template_id);

            if (0 == count($system_mini_template)) {
                admin_toastr('获取微信模板失败', 'warning');

                return redirect()->route('admin.wechat.list', ['type' => 2]);
            }
        }

        //获取模板主题
        $theme = $this->themeTemplateRepository->getThemeItemByTemplateID($template_id);


        //获取体验者微信
        $testers = $this->testerRepository->getListByAppId($appid);

        $server = $this->platformService->getAccount($appid);

        //获取授权小程序帐号的可选类目
        $category = $this->codeService->getCategory($appid);

        //获取小程序的第三方提交代码的页面配置
        $page = '';

        $page = $this->codeService->getPage($appid);


//        if (!$page) {
//            admin_toastr('获取小程序的第三方提交代码的页面配置', 'warning');
//
//            return redirect()->route('admin.wechat.list', ['type' => 2]);
//        }

        $audit = $this->codeService->getAppAuditStatus($appid);


        $status_message = '';

        if ($audit and ibrand_count($audit) > 0) {

            switch ($audit->status) {

                case CodePublish::AUDIT_STATUS:

                    $status_message = '当前有待审核版本';

                    break;

                case  CodePublish::SUCCESS_STATUS  :

                    $status_message = '当前有待发布版本';
                    break;

                default :
                    $audit = [];

                    $status_message = '';
            }

        }

        if ($status_message) {
            $system_mini_template = collect(json_decode($audit->template))->toArray();

            $system_mini_template['type'] = 'audit';

            $theme = $this->themeTemplateRepository->getThemeItemByTemplateID($system_mini_template['template_id']);

            admin_toastr($status_message, 'warning');
        }

        return LaravelAdmin::content(function (Content $content) use ($theme, $appid, $system_mini_template, $testers, $category, $page, $audit, $status_message, $template_id) {
            $content->header('发布小程序');

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序列表']
            );

            $mini_title='首页';

            $mini_tag='商城';

            $mini_address='pages/index/index/index';

            $content->body(view('wechat-platform::mini.code.index', compact('theme', 'system_mini_template', 'appid', 'testers', 'category', 'page', 'audit', 'status_message', 'template_id','mini_title','mini_address','mini_tag')));
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Model()
    {

        $template_id = request('template_id');

        //获取模板主题
        $theme = $this->themeTemplateRepository->getThemeItemByTemplateID($template_id);


        return view('wechat-platform::mini.code.model', compact('theme'));

    }


}
