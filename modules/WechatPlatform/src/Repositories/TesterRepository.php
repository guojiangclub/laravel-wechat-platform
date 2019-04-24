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

use iBrand\Wechat\Platform\Models\Testers;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TesterRepository.
 */
class TesterRepository extends BaseRepository
{
    public function model()
    {
        return Testers::class;
    }

    /**
     * @param $appid
     *
     * @return mixed
     */
    public function getListByAppId($appid)
    {
        return $this->model->where('appid', $appid)->get();
    }

    /**
     * @param $appid
     * @param $wechatid
     *
     * @return mixed
     */
    public function getTesterByWechatId($appid, $wechatid)
    {
        return $this->model->where('appid', $appid)->where('wechatid', $wechatid)->first();
    }

    /**
     * @param $appid
     * @param $wechatid
     *
     * @return mixed
     */
    public function ensureTester($appid, $wechatid)
    {
        $tester = $this->model->where('wechatid', $wechatid)->where('appid', $appid)->first();

        if (!$tester) {
            $tester = $this->model->create(['wechatid' => $wechatid, 'appid' => $appid]);
        }

        return $tester;
    }
}
