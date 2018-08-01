<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Repositories;

use iBrand\Wechat\Platform\Models\Authorizer;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class AuthorizerRepository.
 */
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
     *
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
     *
     * @return mixed
     */
    public function ensureAuthorizer($appid)
    {
        $authorizer = Authorizer::firstOrNew(['appid' => $appid]);

        return $authorizer;
    }

    /**
     * @param $clientId
     * @param int $type
     *
     * @return mixed
     */
    public function getAuthorizersByClient($clientId, $type = 1)
    {
        return Authorizer::where('client_id', $clientId)->where('type', $type)->get();
    }

    /**
     * @param $clientId
     * @param $url
     *
     * @return mixed
     */
    public function updateCallBackUrl($clientId, $url)
    {
        return Authorizer::where('client_id', $clientId)->update(['call_back_url' => $url]);
    }

    /**
     * @param $clientId
     * @param $app_id
     *
     * @return mixed
     */
    public function updateDel($clientId, $app_id)
    {
        return Authorizer::where(['client_id' => $clientId, 'appid' => $app_id])->update(['client_id' => 0]);
    }

    /**
     * @param $appId
     *
     * @return string
     */
    public function getCallBackUrl($appId)
    {
        $res = Authorizer::where('appid', $appId)->first(['call_back_url'])->toArray();

        return isset($res['call_back_url']) ? $res['call_back_url'] : '';
    }

    /**
     * @param $app_id
     */
    public function getAuthorizationByAppID($app_id)
    {
        $authorizer = Authorizer::where(['appid' => $app_id])->first();
        if ($authorizer and $authorizer->client_id) {
            return  $authorizer;
        }

        return null;
    }
}
