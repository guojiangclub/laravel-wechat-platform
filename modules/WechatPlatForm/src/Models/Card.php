<?php

namespace iBrand\Wechat\Platform\Modules\Card;

use iBrand\Wechat\Platform\Modules\OAuth\AccessToken;

class Card extends \EasyWeChat\Card\Card
{
    /**
     * Constructor.
     *
     * @param \Wechat\Modules\OAuth\AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->setAccessToken($accessToken);
    }
}
