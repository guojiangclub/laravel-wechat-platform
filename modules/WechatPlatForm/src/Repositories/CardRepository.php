<?php

/*
 * add .styleci.yml
 */

namespace iBrand\Wechat\Platform\Repositories;

use iBrand\Wechat\Platform\Models\Card;

/**
 * Card 仓库.
 */
class CardRepository
{
    /**
     * 保存Card.
     * @param $appid
     * @param $card_id
     * @param $code
     * @param $openid
     * @return mixed
     */
    public function createCard($appid, $card_id, $code, $openid)
    {
        return Card::firstOrNew(['appid' => $appid, 'card_id' => $card_id, 'code' => $code, 'openid' => $openid]);
    }

    /**
     * 获取code.
     * @param $appid
     * @param $card_id
     * @param $openid
     * @return mixed
     */
    public function getCode($appid, $card_id, $openid)
    {
        return Card::where('appid', $appid)
            ->where('card_id', $card_id)
            ->where('openid', $openid)
            ->first();
    }

    /**
     * 删除会员卡
     * @param $appid
     * @param $card_id
     * @param $code
     * @param $openid
     */
    public function deleteCard($appid, $card_id, $code, $openid)
    {
        Card::where('appid', $appid)
            ->where('card_id', $card_id)
            ->where('code', $code)
            ->where('openid', $openid)
            ->delete();
    }
}
