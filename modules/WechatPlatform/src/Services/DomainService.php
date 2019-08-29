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
 * 服务器域名设置
 * Class TemplateMessageService.
 */
class DomainService
{
    protected $platformService;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platformService = $platformService;
    }

    /**
     * @param $appid
     * @param array $data
     */
    public function action($appid, $data = [])
    {
        if (!isset($data['action'])) {
            $data['action'] = 'get';
        }

//        if ('get' != $data['action']) {
//            dd($data);
//        }

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $server;
        }



        return $server->domain->modify($data);
    }

    /**
     * @return array
     */
    public function local()
    {
        if (!settings('requestdomain')
            and !settings('wsrequestdomain')
            and !settings('uploaddomain')
            and !settings('downloaddomain')) {
            return [];
        }

        $data['requestdomain'] = settings('requestdomain') ? settings('requestdomain') : [];

        $data['wsrequestdomain'] = settings('wsrequestdomain') ? settings('wsrequestdomain') : [];

        $data['uploaddomain'] = settings('uploaddomain') ? settings('uploaddomain') : [];

        $data['downloaddomain'] = settings('downloaddomain') ? settings('downloaddomain') : [];

        return $data;
    }

    /**
     * @param array $domain
     * @param array $local
     *
     * @return array
     */
    public function filterDomain(array $domain, array $local)
    {
        $data = [];

        foreach ($domain as $k => $item) {
            if (is_array($item) AND isset($local[$k]) AND count($local[$k]) > 0) {
                foreach ($local[$k] as $litem) {
                    if (!in_array($litem, $domain[$k])) {
                        //$data[$k]=$local[$k];

                        $data = $local;
                    }
                }
            }
        }

        return $data;
    }

     /**
     * @param $appid
     * @param array $data
     * @param string $action
     * @return array|\EasyWeChat\Kernel\Support\Collection|\EasyWeChat\OpenPlatform\Application|\EasyWeChat\OpenPlatform\Authorizer\MiniProgram\Application|\EasyWeChat\OpenPlatform\Authorizer\OfficialAccount\Application|null|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
      public function setWebviewDomain($appid, $data = [],$action='add'){

        $server = $this->platformService->getAccount($appid);

        if (null == $server) {
            return $server;
        }

        return $server->domain->setWebviewDomain($data,$action);

    }
}
