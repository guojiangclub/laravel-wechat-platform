<?php

namespace iBrand\Wechat\Platform\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use iBrand\Wechat\Platform\Models\Authorizer;

class AuthorizerRepository extends BaseRepository
{
    public function model()
    {
        return Authorizer::class;
    }

    /**
     * 获取APP授权.
     *
     * @param $appid
     * @return Authorizer
     */
    public function getAuthorizer($appid)
    {
        $authorizer = Authorizer::where('appid', $appid)->first();

        return $authorizer;
    }

    /**
     * 获取APP授权, 不存在则创建一个.
     *
     * @param $appid
     */
    public function ensureAuthorizer($appid)
    {
        $authorizer = Authorizer::firstOrNew(['appid' => $appid]);

        return $authorizer;
    }

    public function getAuthorizersByClient($clientId)
    {
        return Authorizer::where('client_id', $clientId)->get();
    }

    public function updateCallBackUrl($clientId, $url)
    {
        return Authorizer::where('client_id', $clientId)->update(['call_back_url'=>$url]);
    }


    public function updateDel($clientId, $app_id)
    {
        return Authorizer::where(['client_id'=>$clientId,'appid'=>$app_id])->update(['client_id'=>0]);
    }

    public function getCallBackUrl($appId)
    {
        $res = Authorizer::where('appid', $appId)->first(['call_back_url'])->toArray();

        return isset($res['call_back_url'])?$res['call_back_url']:'';
    }

    public function getAuthorizationByAppID($app_id){
        $authorizer=Authorizer::where(['appid'=>$app_id])->first();
        if($authorizer AND $authorizer->client_id){
            return  $authorizer;
        }
        return null;
    }

}