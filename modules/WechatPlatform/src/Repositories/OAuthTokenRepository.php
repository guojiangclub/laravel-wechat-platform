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

use iBrand\Wechat\Platform\Models\Oauth2Token;

/**
 * OAuthToken 仓库.
 * Class OAuthTokenRepository.
 */
class OAuthTokenRepository
{
    /**
     * 获取授权TOKEN.
     *
     * @param $appid
     * @param $openid
     *
     * @return mixed
     */
    public function getToken($appid, $openid)
    {
        $oauth_token = Oauth2Token::where('appid', $appid)
            ->where('openid', $openid)
            ->first();

        return $oauth_token;
    }

    /**
     * 获取APP授权, 不存在则创建一个.
     *
     * @param $appid
     * @param $openid
     *
     * @return mixed
     */
    public function ensureToken($appid, $openid)
    {
        return Oauth2Token::firstOrNew(['appid' => $appid, 'openid' => $openid]);
    }
}
