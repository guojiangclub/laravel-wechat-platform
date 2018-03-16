<?php


namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;
use iBrand\Wechat\Platform\Services\MessageService;


class NotifyController extends Controller
{

    protected $platformService;

    protected $messageService;

    public function __construct(
        PlatformService $platformService
        ,MessageService $messageService
    )
    {
        $this->platformService=$platformService;
        $this->messageService=$messageService;

    }

    /**
     * 授权事件接收URL.
     *
     * @param PlatformService $component
     * @return string
     */
    public function notifyPlatform()
    {
        return $this->platformService->authEventProcess();
    }


    /**
     * 公众号消息与事件接收URL.
     */
    public function notifyAccount($appid)
    {
        return  $this->messageService->accountEventProcess($appid);
    }


}
