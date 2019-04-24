<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Services;

use iBrand\Wechat\Platform\Repositories\CodePublishRepository;

class CodeService
{
    protected $platformService;

    protected $codePublishRepository;

    public function __construct(
        PlatformService $platformService,

        CodePublishRepository $codePublishRepository
    ) {
        $this->platformService = $platformService;

        $this->codePublishRepository = $codePublishRepository;
    }

    /**
     * @param $appid
     *
     * @return array
     */
    public function getCategory($appid)
    {
        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return [];
        }

        $res = $server->code->getCategory();

        return isset($res['category_list']) ? $res['category_list'] : [];
    }

    /**
     * @param $appid
     *
     * @return array|string
     */
    public function getPage($appid)
    {
        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return [];
        }

        $res = $server->code->getPage();

        return isset($res['page_list'][0]) ? $res['page_list'][0] : '';
    }

    /**
     * @param $appid
     *
     * @return array|null
     */
    public function getLatestAuditStatus($appid)
    {
        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return [];
        }

        $res = $server->code->getLatestAuditStatus();

        if (isset($res['errcode']) and 0 == $res['errcode']) {
            return $res;
        }

        return null;
    }

    /**
     * @param $appid
     *
     * @return array|mixed|null
     */
    public function getAppAuditStatus($appid)
    {
        $audit = $this->codePublishRepository->getAuditByAppID($appid);

        if (!$audit) {
            return null;
        }

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return [];
        }

        $res = $server->code->getAuditStatus($audit->auditid);

        $res_reason = isset($res['reason']) ? $res['reason'] : '';

        if (isset($res['status'])) {
            return $this->codePublishRepository->renew($audit, $res['status'], $res_reason);
        }

        return $audit;
    }
}
