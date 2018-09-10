<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Repositories;

use iBrand\Wechat\Platform\Models\ThemeItems;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ThemeTemplateRepository.
 */
class ThemeItemsRepository extends BaseRepository
{
    public function model()
    {
        return ThemeItems::class;
    }

    /**
     * @param $theme_id
     * @param int $limit
     *
     * @return mixed
     */
    public function getAll($theme_id, $type = 1, $limit = 20)
    {
        return $this->model
            ->where('theme_id', $theme_id)
            ->where('type', $type)
            ->where('theme_id', '<>', 0)->orderBy('created_at', 'desc')->paginate($limit);
    }

    /**
     * @param $id
     * @param $theme_id
     *
     * @return mixed
     */
    public function setDefaultTheme($id, $theme_id, $type = 1)
    {
        $default = $this->model->where('is_default', 1)->where('theme_id', $theme_id)->where('type', $type)->first();

        if ($default) {
            $default->is_default = 0;

            $default->save();
        }

        $item = $this->model->find($id);

        $item->is_default = 1;

        return $item->save();
    }
}
