<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers\MiniProgram;

use iBrand\Wechat\Platform\Http\Controllers\Controller;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 小程序代码管理
 * Class CodeController.
 */
class CodeController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 为授权的小程序帐号上传小程序代码
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function commit()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->commit($data['template_id'], $data['ext_json'], $data['user_version'], $data['user_desc']);

        // 返回JSON
        return $result;
    }

    /**
     *获取体验小程序的体验二维码
     *
     * @return \EasyWeChat\Kernel\Http\Response
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getQrCode()
    {
        // 参数
        $appid = request('appid');

        $path = request('path');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->getQrCode($path);

        header('Content-type: image/jpg');

        echo $result;
    }

    /**
     *获取授权小程序帐号的可选类目.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getCategory()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->getCategory();

        // 返回JSON
        return $result;
    }

    /**
     *获取小程序的第三方提交代码的页面配.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getPage()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->getPage();

        // 返回JSON
        return $result;
    }

    /**
     * 将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function submitAudit()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->submitAudit($data['item_list']);

        // 返回JSON
        return $result;
    }

    /**
     * 获取审核结果.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getAuditStatus()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->getAuditStatus($data['auditid']);

        // 返回JSON
        return $result;
    }

    /**
     * 查询最新一次提交的审核状态（仅供第三方代小程序调用）.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getLatestAuditStatus()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->getLatestAuditStatus();

        // 返回JSON
        return $result;
    }

    /**
     * 发布已通过审核的小程序（仅供第三方代小程序调用）.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function release()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->release();

        // 返回JSON
        return $result;
    }

    /**
     *小程序审核撤回(单个帐号每天审核撤回次数最多不超过1次，一个月不超过10次).
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function withdrawAudit()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->withdrawAudit();

        // 返回JSON
        return $result;
    }

    /**
     * 小程序版本回退
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function rollbackRelease()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->rollbackRelease();

        // 返回JSON
        return $result;
    }

    /**
     *修改小程序线上代码的可见状态
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function changeVisitStatus()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->changeVisitStatus($data['action']);

        // 返回JSON
        return $result;
    }

    /**
     *分阶段发布接口.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function grayRelease()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->grayRelease($data['gray_percentage']);

        // 返回JSON
        return $result;
    }

    /**
     * 取消分阶段发布.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function revertGrayRelease()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->revertGrayRelease();

        // 返回JSON
        return $result;
    }

    /**
     * 查询当前分阶段发布详情.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getGrayRelease()
    {
        // 参数
        $appid = request('appid');

        // 授权
        $server = $this->platform->miniProgramAPI($appid);

        // 调用接口
        $result = $server->code->getGrayRelease();

        // 返回JSON
        return $result;
    }
}
