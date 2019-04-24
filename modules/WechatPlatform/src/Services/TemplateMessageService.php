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

/**
 * 小程序模板消息设置
 * Class TemplateMessageService.
 */
class TemplateMessageService
{
    protected $platformService;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platformService = $platformService;
    }

    /**
     * @param $appid
     */
    public function list($appid)
    {
        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $server;
        }

        return $server->template_message->list();
    }
}
