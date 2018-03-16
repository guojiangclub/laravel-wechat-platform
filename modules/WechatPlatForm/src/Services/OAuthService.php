<?php

namespace iBrand\Wechat\Platform\Services;


use iBrand\Wechat\Platform\Repositories\OAuthTokenRepository;

/**
 * 第三方OAuthService服务
 */
class OAuthService
{

    const API_USERINFO = 'https://api.weixin.qq.com/sns/userinfo';

    protected $repository;

    public function __construct(
        OAuthTokenRepository $repository
 )
    {
        $this->repository = $repository;
    }

    /**
     * 保存用户授权信息.
     *
     */
    public function saveAuthorization($user,$appid)
    {
        // 保存Token
        $token = $this->repository->ensureToken($appid, $user->id);
        $token->access_token = $user->token->access_token;
        $token->refresh_token = $user->token->refresh_token;
        $token->scope =$user->token->scope;
        $token->expires_in = $user->token->expires_in;
        $token->save();
        return $token;
    }

    /**
     * 获取refresh_token
     */
    public function getRefreshToken($appid, $openid){
         if($token = $this->repository->getToken($appid, $openid)){
             return $token->refresh_token;
         }
         return null;
    }


    public function getUserInfo($appid,$openid){

        if(!$token = $this->repository->getToken($appid, $openid)){
            return null;
        }
        $abs_url = self::API_USERINFO.'?openid='.$openid.'&access_token='.$token->access_token."&lang=zh_CN";

        $abs_url_data = file_get_contents($abs_url);

        $obj_data=json_decode($abs_url_data,true);

        return  $obj_data;
    }



    

}
