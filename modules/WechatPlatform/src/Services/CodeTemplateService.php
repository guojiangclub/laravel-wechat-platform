<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Services;

/**
 * 小程序代码模版库管理服务
 * Class CodeTemplateService.
 */
class CodeTemplateService
{
    const DRAFT = 1; //草稿箱

    const FORMAL = 2; //正式模板

    protected $platformService;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platformService = $platformService;
    }

    /**
     * 获取草稿箱内的所有临时代码草稿
     *
     * @return mixed
     */
    public function getCodeTemplateGetDrafts()
    {
        return $this->platformService->server->code_template->getDrafts();
    }

    /**
     * 将草稿箱的草稿选为小程序代码模版.
     *
     * @param $draft_id
     *
     * @return mixed
     */
    public function getCodeTemplateCreateFromDraft($draft_id)
    {
        return $server = $this->platformService->server->code_template->CreateFromDraft($draft_id);
    }

    /**
     * 获取代码模版库中的所有小程序代码模版.
     *
     * @param $draft_id
     *
     * @return mixed
     */
    public function getCodeTemplateList()
    {
        return $server = $this->platformService->server->code_template->list();
    }

    /**
     * 删除指定小程序代码模版.
     *
     * @param $draft_id
     *
     * @return mixed
     */
    public function deleteCodeTemplate($template_id)
    {
        return $server = $this->platformService->server->code_template->delete($template_id);
    }

    /**
     * @param $template_id
     *
     * @return array
     */
    public function getCodeTemplateByTemplateID($template_id)
    {
        $list = $this->platformService->server->code_template->list();

        if (isset($list['template_list'])) {
            if (count($list['template_list'])) {
                foreach ($list['template_list'] as $item) {
                    if ($template_id == $item['template_id']) {
                        return $item;
                    }
                }
            }
        }

        return [];
    }
}
