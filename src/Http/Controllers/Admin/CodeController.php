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

use Carbon\Carbon;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use iBrand\Wechat\Platform\Http\Controllers\Controller;
use iBrand\Wechat\Platform\Models\CodePublish;
use iBrand\Wechat\Platform\Repositories\CodePublishRepository;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 小程序代码管理
 * Class CodeController.
 */
class CodeController extends Controller
{
    protected $platform;

    protected $codePublishRepository;

    public function __construct(
        PlatformService $platformService,

        CodePublishRepository $codePublishRepository
    ) {
        $this->platform = $platformService;

        $this->codePublishRepository = $codePublishRepository;
    }

    /**
     * 为授权的小程序帐号上传小程序代码
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function commit()
    {
        // 参数
        $appid = request('appid');

        $data = request()->except('_token');

        // 授权
        $server = $this->platform->getAccount($appid);

        $data['ext_json'] = json_encode($data['ext_json'], true);

        if(isset($data['ext_json']['tabBar']['list'][0]['pagePath'])){

            $data['ext_json']['ext']['firstPagePath']=$data['ext_json']['tabBar']['list'][0]['pagePath'];

        }

        // 调用接口
        $result = $server->code->commit($data['template_id'], $data['ext_json'], $data['user_version'], $data['user_desc']);

        // 返回JSON
        return $this->admin_wechat_api($result);
    }

    /**
     * 获取体验小程序的体验二维码
     *
     * @return mixed
     */
    public function getQrCode()
    {
        // 参数
        $appid = request('appid');

        $path = request('path');

        // 授权
        $server = $this->platform->getAccount($appid);

        // 调用接口
        $result = $server->code->getQrCode($path);

        if ('image' == request('type')) {
            header('Content-Type: image/png');

            echo $result;
        }

        return $result;
    }

    /**
     * 获取小程序二维码
     *
     * @return mixed
     */
    public function getAppQrCode()
    {
        // 参数
        $appid = request('appid');

        $width = request('width') ? request('width') : null;

        $path = request('path');

        // 授权
        $server = $this->platform->getAccount($appid);

        // 调用接口
        $result = $server->app_code->getQrCode($path, $width);

        if ('image' == request('type')) {
            header('Content-Type: image/png');

            echo $result;
        }

        // 返回JSON
        return $result;
    }

    /**
     * 将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitAudit()
    {
        // 参数
        $new_data = [];

        $appid = request('appid');

        $data = request()->except('_token', 'appid');

        $new_data[0] = $data['item_list'];

        //授权
        $server = $this->platform->getAccount($appid);

        //调用接口
        $result = $server->code->submitAudit($new_data);

        if (isset($result['auditid'])) {
            $data['log']['template'] = json_encode($data['log']['template'], true);

            $data['log']['theme'] = isset($data['log']['theme']) ? json_encode($data['log']['theme'], true) : '';

            $data['log']['bars'] = isset($data['log']['bars']) ? json_encode($data['log']['bars'], true) : '';

            $data['log']['ext_json'] = json_encode($data['log']['ext_json'], true);

            $data['log']['status'] = CodePublish::AUDIT_STATUS;

            $data['log']['auditid'] = $result['auditid'];

            $data['log']['audit_time'] = date('Y-m-d H:i:s', Carbon::now()->timestamp);

            $this->codePublishRepository->getItemOrCreate($data['log']);
        }

        // 返回JSON
        return $this->admin_wechat_api($result);
    }

    /**
     * 撤回审核.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function withdrawAudit()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->getAccount($appid);

        // 调用接口
        $result = $server->code->withdrawAudit();

        if (isset($result['errcode']) and 0 == $result['errcode']) {
            $item = $this->codePublishRepository->getAuditByAppID($appid);

            if ($item and CodePublish::WITHDRW_STATUS != $item->status) {
                $data['status'] = CodePublish::WITHDRW_STATUS;

                $data['withdraw_audit_time'] = date('Y-m-d H:i:s', Carbon::now()->timestamp);

                $this->codePublishRepository->update($data, $item->id);
            }
        }

        // 返回JSON
        return $this->admin_wechat_api($result);
    }

    /**
     * 发布已通过审核的小程序.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function release()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->getAccount($appid);

        // 调用接口
        $result = $server->code->release();

//        $result = [
//            "errcode" => 0,
//            "errmsg" => "ok",
//        ];

        if (isset($result['errcode']) and 0 == $result['errcode']) {
            $item = $this->codePublishRepository->getAuditByAppID($appid);

            if ($item and CodePublish::PUBLISH_STATUS != $item->status) {
                $data['status'] = CodePublish::PUBLISH_STATUS;

                $data['release_time'] = date('Y-m-d H:i:s', Carbon::now()->timestamp);

                $this->codePublishRepository->update($data, $item->id);
            }
        }

        // 返回JSON
        return $this->admin_wechat_api($result);
    }

    /**
     * @return Content
     */
    public function log()
    {
        $appid = request('appid');

        $limit = request('limit') ? request('limit') : 20;

        $lists = $this->codePublishRepository->getListsByAppId($appid, $auditid = null, $limit);

        return LaravelAdmin::content(function (Content $content) use ($lists, $appid) {
            $content->header('小程序发布记录');

            $content->description($appid);

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序发布记录', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序列表']
            );

            $content->body(view('wechat-platform::mini.code.log', compact('lists')));
        });
    }
}
