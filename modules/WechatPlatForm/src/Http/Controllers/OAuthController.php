<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\OAuthService;
use iBrand\Wechat\Platform\Services\PlatformService;
use Illuminate\Support\Facades\Redirect;


class OAuthController extends Controller
{
    const OAUTH_REDIRECT = 'oauth.redirect';
    const API_USERINFO = 'https://api.weixin.qq.com/sns/userinfo';

    protected $OAuthService;

    protected $platformService;


    public function __construct(
        PlatformService $platformService
        ,OAuthService $OAuthService

    )
    {
        $this->platformService=$platformService;
        $this->OAuthService=$OAuthService;

    }

    /**
     * 第三方登录.
     */
    public function oauth()
    {
        // 参数
        $appid = request('appid');

        $scope = !empty(request('scope')) ? request('scope') : 'snsapi_userinfo';

        $server= $this->platformService->authorizeAPI($appid);

        // 记录回调地址
        session([self::OAUTH_REDIRECT => request('redirect')]);

        return  $response=$server->oauth->scopes(["$scope"])->redirect();


    }

    /**
     * 第三方登录回调
     */
    public function result()
    {
        $request=request()->all();

        if(!isset($request['appid']) || !isset($request['code']) || !isset($request['state'])) return view('welcome');

        $server= $this->platformService->authorizeAPI($request['appid']);

        $user=$server->oauth->user();

        $this->OAuthService->saveAuthorization($user,$request['appid']);

        // 回调返回openid
        $url = session(self::OAUTH_REDIRECT).'?openid='.$user->id;

        return Redirect::to($url);

    }

    /**
     * 获取用户信息.
     */
    public function userinfo()
    {
        $appid = request('appid');

        $openid = request('openid');

        $server= $this->platformService->authorizeAPI($appid);

        return $this->OAuthService->getUserInfo($appid,$openid);

    }



}
