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

use iBrand\Wechat\Platform\Models\ThemeTemplate;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ThemeTemplateRepository.
 */
class ThemeTemplateRepository extends BaseRepository
{

    public function model()
    {
        return ThemeTemplate::class;
    }


    /**
     * @param $template_id
     * @return mixed
     */
    public function getThemeItemByTemplateID($template_id)
    {

        return $this->model
            ->where('template_id', $template_id)
            ->with('theme')
            ->with('theme.items')
            ->with('theme.bars')
            ->first();
    }

    /**
     * @param $template_id
     * @return mixed
     */
    public function getThemefirstByTemplateID($template_id)
    {
        return $this->model->where('template_id', $template_id)->first();
    }


    /**
     * @param $template_id
     * @param $theme_id
     * @return mixed
     */
    public function operateThemeTemplate($template_id, $theme_id)
    {

        $theme_template = $this->model->where('template_id', $template_id)->first();

        if ($theme_template) {

            $theme_template->theme_id = $theme_id;

            return $theme_template->save();
        }

        return $this->model->create(['template_id' => $template_id, 'theme_id' => $theme_id]);

    }



}
