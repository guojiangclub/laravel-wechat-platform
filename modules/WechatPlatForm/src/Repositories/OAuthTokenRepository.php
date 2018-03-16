<?php

namespace iBrand\Wechat\Platform\Repositories;

use iBrand\Wechat\Platform\Models\Oauth2Token;

/**
 * OAuthToken 仓库.
 */
class OAuthTokenRepository
{
    /**
     * 获取授权TOKEN.
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
     */
    public function ensureToken($appid, $openid)
    {
        return Oauth2Token::firstOrNew(['appid' => $appid, 'openid' => $openid]);
    }
}
