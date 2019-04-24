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

use iBrand\Wechat\Platform\Models\Clients;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ClientsRepository.
 */
class ClientsRepository extends BaseRepository
{
    public function model()
    {
        return Clients::class;
    }

    /**
     * @param $name
     * @param int $limit
     *
     * @return mixed
     */
    public function getListsByname($name, $limit = 20)
    {
        $query = $this->model;

        if ($name) {
            $query = $query->where('name', 'like', '%'.$name.'%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($limit);
    }
}
