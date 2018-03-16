<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;
use iBrand\Wechat\Platform\Models\Clients;


class PlatformController extends Controller
{

    protected $platformService;

    public function __construct(
        PlatformService $platformService
    )
    {
        $this->platformService=$platformService;
    }


    /**
     * 引导用户进入授权页.
     * @return mixed
     */

    public function auth()
    {

        $clientId = request('client_id');

//       $redirectUrl = request('redirect_url');

        $callback = route('component.auth.result', ['client_id' => $clientId]);

        $url=$this->platformService->authRedirectUrl($callback);

        return view('wechat-platform::platform.auth', ['redirect_url' => $url]);
    }

    /**
     * 保存授权信息.
     * @return string
     * @internal param Request $request
     */
    public function authResult()
    {
        $auth_code = request('auth_code');
        $authorizer=$this->platformService->saveAuthorization($auth_code);
        if ($clientId = request('client_id')) {
            $authorizer->client_id = $clientId;
            $authorizer->save();
        }
        return '授权成功！';
    }



    public function getToken(){

        $clientId = request('client_id');

        $client_secret = request('client_secret');

        $client= Clients::where('id',$clientId)->where('secret',$client_secret)->first();

        if(!$client)  return response()
            ->json(['token_type' => 'Bearer', 'access_token' => '']);

        $token = $client->createToken($client->secret)->accessToken;

        return response()
            ->json(['token_type' => 'Bearer', 'access_token' => $token]);
    }
}
