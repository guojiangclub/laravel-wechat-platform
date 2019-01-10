<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Repositories\AuthorizerRepository;
use iBrand\Wechat\Platform\Services\MessageService;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * Class NotifyController.
 */
class NotifyController extends Controller
{
    protected $platformService;

    protected $messageService;

    protected $authorizerRepository;

    public function __construct(
        PlatformService $platformService, MessageService $messageService, AuthorizerRepository $authorizerRepository
    ) {
        $this->platformService = $platformService;
        $this->messageService = $messageService;
        $this->authorizerRepository = $authorizerRepository;
    }

    /**
     * 授权事件接收URL.
     *
     * @param PlatformService $component
     *
     * @return string
     */
    public function notifyPlatform()
    {
        return $this->platformService->authEventProcess();
    }

    /**
     * 公众号消息与事件接收URL.
     *
     * @param $appid
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function notifyAccount($appid)
    {
        if ('wx570bc396a51b8ff8' == $appid) {
            return $this->messageService->FullNetworkReleaseReceiver($appid);
        }

        $authorizer = $this->authorizerRepository->getAuthorizer($appid);

        if (isset($authorizer->type) and 2 == $authorizer->type) {
            return $this->messageService->miniProgramProcess($appid);
        }

        return $this->messageService->accountEventProcess($appid);
    }
}
