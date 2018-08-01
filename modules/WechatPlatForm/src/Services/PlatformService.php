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

use EasyWeChat\Factory;
use EasyWeChat\OpenPlatform\Server\Guard;
use iBrand\Wechat\Platform\Models\Authorizer;
use iBrand\Wechat\Platform\Repositories\AuthorizerRepository;

/**
 * 第三方平台服务
 * Class PlatformService.
 */
class PlatformService
{
    /**
     * 仓库.
     *
     * @var
     */
    protected $authorizerRepository;

    /**
     * 第三方平台事件接口.
     *
     * @var
     */
    protected $server;

    /**
     * ComponentService constructor.
     *
     * @param AuthorizerRepository $repository
     * @param Guard                $server
     */
    public function __construct(
        AuthorizerRepository $authorizerRepository
    ) {
        $this->authorizerRepository = $authorizerRepository;
        $this->server = Factory::openPlatform(config('wechat-platform.open_platform.default'));
    }

    /**
     * 平台授权事件处理.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function authEventProcess()
    {
        $server = $this->server->server;

        // 处理授权取消事件
        $server->push(function ($message) {
            if (isset($message['AuthorizerAppid'])) {
                Authorizer::where(['appid' => $message['AuthorizerAppid']])->update(['client_id' => 0]);
            }
        }, Guard::EVENT_UNAUTHORIZED);

        return $server->serve();
    }

    /**
     * 步骤2：引入用户进入授权页
     * 第三方平台方可以在自己的网站:中放置“微信公众号授权”的入口，引导公众号运营者进入授权页。授权页网址为
     * https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=xxxx&pre_auth_code=xxxxx&redirect_uri=xxxx，
     * 该网址中第三方平台方需要提供第三方平台方appid、预授权码和回调URI.
     *
     * @param $callback
     *
     * @return mixed
     */
    public function authRedirectUrl($callback, $authCode = null)
    {
        return $this->server->getPreAuthorizationUrl($callback, $authCode);
    }

    /**
     * 步骤4：授权后回调URI，得到授权码（authorization_code）和过期时间
     * 授权流程完成后，授权页会自动跳转进入回调URI，并在URL参数中返回授权码和过期时间(redirect_url?auth_code=xxx&expires_in=600)
     * 在得到授权码后，第三方平台方可以使用授权码换取授权公众号的接口调用凭据（authorizer_access_token，也简称为令牌）.
     *
     * @param $auth_code
     */
    public function saveAuthorization($auth_code)
    {
        // 换取公众号的接口调用凭据
        $result = $this->server->handleAuthorize($auth_code);
        if (!isset($result['authorization_info'])) {
            return;
        }
        $info = $result['authorization_info'];

        // 获取公众号基本信息
        $authorzer_info = $this->server->getAuthorizer($info['authorizer_appid']);

        \Log::info($authorzer_info);

        $basic_info = $authorzer_info['authorizer_info'];

        // 创建一个授权对象
        $authorizer = $this->authorizerRepository->firstOrCreate(['appid' => $info['authorizer_appid']]);

        // 刷新令牌主要用于公众号第三方平台获取和刷新已授权用户的access_token，只会在授权时刻提供，请妥善保存。 一旦丢失，只能让用户重新
        // 授权，才能再次拿到新的刷新令牌
        $authorizer->refresh_token = $info['authorizer_refresh_token'];
        $authorizer->func_info = \GuzzleHttp\json_encode($info['func_info']);

        // 基本信息
        $authorizer->service_type_info = $basic_info['service_type_info']['id'];
        $authorizer->verify_type_info = $basic_info['verify_type_info']['id'];

        $authorizer->nick_name = urldecode($basic_info['nick_name']);
        $authorizer->head_img = isset($basic_info['head_img']) ? $basic_info['head_img'] : '';
        $authorizer->user_name = urldecode($basic_info['user_name']);
        $authorizer->principal_name = urldecode($basic_info['principal_name']);
        $authorizer->qrcode_url = $basic_info['qrcode_url'];

        if (isset($basic_info['MiniProgramInfo'])) {
            $authorizer->mini_info = \GuzzleHttp\json_encode($basic_info['MiniProgramInfo']);
            $authorizer->type = 2;
        }
        // 保存到数据库
        $authorizer->save();

        return $authorizer;
    }

    /**
     * 给API对象授权
     * 步骤5：利用授权码调用用户公众号的相关API.
     *
     * @param $appid
     */
    public function authorizeAPI($appid)
    {
        // 获取Token
        $authorizer = $this->authorizerRepository->getAuthorizationByAppID($appid);

        if ($authorizer) {
            return $officialAccount = $this->server->officialAccount($appid, $authorizer->refresh_token);
        }

        throw new \Exception('Unauthorised', 3);
    }
}
