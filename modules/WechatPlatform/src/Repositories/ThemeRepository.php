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

use iBrand\Wechat\Platform\Models\Theme;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ThemeTemplateRepository.
 */
class ThemeRepository extends BaseRepository
{

    public function model()
    {
        return Theme::class;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getAll($limit = 20)
    {
        return $this->model->orderBy('updated_at', 'desc')->paginate($limit);
    }

    /**
     * @return mixed
     */
    public function getlists()
    {

        return $this->model->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null
     */
    public function getThemeInfoBy($id)
    {

        return $this->model->with('items')->with('bars')->find($id);
    }


}
