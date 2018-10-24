<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers\Admin;

use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use iBrand\Wechat\Platform\Http\Controllers\Controller;
use iBrand\Wechat\Platform\Repositories\ThemeItemsRepository;
use iBrand\Wechat\Platform\Repositories\ThemeRepository;
use iBrand\Wechat\Platform\Repositories\ThemeTemplateRepository;
use iBrand\Wechat\Platform\Services\PlatformService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ThemeController.
 */
class ThemeController extends Controller
{
    protected $platformService;

    protected $errcode;

    protected $themeTemplateRepository;

    protected $themeRepository;

    protected $themeItemsRepository;

    public function __construct(
        PlatformService $platformService,
        ThemeTemplateRepository $themeTemplateRepository,
        ThemeItemsRepository $themeItemsRepository,
        ThemeRepository $themeRepository
    ) {
        $this->platformService = $platformService;

        $this->themeTemplateRepository = $themeTemplateRepository;

        $this->themeItemsRepository = $themeItemsRepository;

        $this->themeRepository = $themeRepository;

        $this->errcode = config('mini_program_errcode');
    }

    /**
     * @return Content
     */
    public function index()
    {
        $lists = [];

        $limit = request('limit') ? request('limit') : 20;

        $lists = $this->themeRepository->getAll($limit);

        $template_id = request('template_id');

        return LaravelAdmin::content(function (Content $content) use ($lists) {
            $content->header('小程序主题');

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序主题', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序主题']
            );

            $content->body(view('wechat-platform::mini.theme.index', compact('lists')));
        });
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $item = $this->themeTemplateRepository->findWhere(['theme_id' => $id]);

        if (count($item) > 0) {
            return $this->api([], false, 400, '有小程序模板在使用该主题组删除失败');
        }

        if ($this->themeRepository->delete($id)) {
            return $this->api([], true);
        }

        return $this->api([], false, 400, '删除失败');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $name = request('name');

        $theme = $this->themeRepository->findWhere(['name' => $name])->first();

        if (!$theme) {
            $this->themeRepository->create(['name' => $name]);

            return $this->api([], true);
        }

        return $this->api([], false, 400, '名称已经存在');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update()
    {
        $name = request('name');

        $id = request('id');

        $theme = $this->themeRepository->findWhere(['name' => $name])->first();

        if (!$theme || $theme->id == $id) {
            $this->themeRepository->update(['name' => $name], $id);

            return $this->api([], true);
        }

        return $this->api([], false, 400, '名称已经存在');
    }

    /**
     * @param $id
     *
     * @return Content
     */
    public function items()
    {
        $lists = [];

        $view = 'wechat-platform::mini.theme.items';

        $name = request('name');

        $type = request('type') ? request('type') : 1;

        $limit = request('limit') ? request('limit') : 20;

        $theme_id = request('theme_id');

        if (2 == $type) {
            $view = 'wechat-platform::mini.theme.bars';
        }

        $lists = $this->themeItemsRepository->getAll($theme_id, $type, $limit);

        return LaravelAdmin::content(function (Content $content) use ($lists, $name, $type, $view) {
            $content->header($name.'主题列表');

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序主题', 'url' => 'wechat_platform/mini/theme', 'no-pjax' => 1],
                ['text' => '主题详情列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序主题']
            );

            $content->body(view($view, compact('lists', 'name','type')));
        });
    }

    /**
     * @param $id
     *
     * @return Content
     */
    public function itemEdit($id)
    {
        $param = [];

        $view = 'wechat-platform::mini.theme.edit';

        $type = request('type');

        $item = $this->themeItemsRepository->find($id);

        if (2 == $type) {
            $view = 'wechat-platform::mini.theme.bars_edit';
        }

        if ($item and !empty($item->param)) {
            $param = json_decode($item->param, true);
        }

        return LaravelAdmin::content(function (Content $content) use ($item, $param, $id, $view) {
            $content->header('编辑主题');

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序主题', 'url' => 'wechat_platform/mini/theme', 'no-pjax' => 1],
                ['text' => '编辑主题', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序主题']
            );

            $content->body(view($view, compact('item', 'param', 'id')));
        });
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function itemUpdate($id)
    {
        if (2 == request('type')) {
            $param = str_replace(["\r\n", "\r", "\n", ' '], '', request('param'));

            $this->themeItemsRepository->update(['title' => request('title'), 'param' => $param], $id);

            return $this->api([], true);
        }

        if (1 == request('type')) {
            $data = $this->getParam();

            if (empty($data['param'])) {
                return $this->api([], false, 400, '自定义属性不能为空');
            }

            if ($this->themeItemsRepository->update($data, $id)) {
                return $this->api([], true);
            }
        }

        return $this->api([], false);
    }

    /**
     * @return array
     */
    protected function getParam()
    {
        $data = [];

        $input = request()->except('_token', 'file');

        $param = [];

        foreach ($input['key'] as $k => $v) {
            if ($v) {
                $param[$v] = $input['value'][$k];
            }
        }

        $data['param'] = '';

        if (count($param) > 0) {
            $data['param'] = json_encode($param, true);
        }

        $data['img'] = $input['img'];

        $data['title'] = $input['title'];

        if (isset($input['theme_id'])) {
            $data['theme_id'] = $input['theme_id'];
        }

        return $data;
    }

    /**
     * @return Content
     */
    public function itemCreate()
    {
        $theme_id = request('theme_id');

        $type=request('type');

        $view = 'wechat-platform::mini.theme.create';

        if (2 == request('type')) {
            $view = 'wechat-platform::mini.theme.bars_create';
        }

        return LaravelAdmin::content(function (Content $content) use ($theme_id,$view,$type) {
            $content->header('添加主题');

            $content->breadcrumb(
                ['text' => '小程序管理', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序列表', 'url' => 'wechat_platform/wechat?type=2', 'no-pjax' => 1],
                ['text' => '小程序主题', 'url' => 'wechat_platform/mini/theme', 'no-pjax' => 1],
                ['text' => '添加主题', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '小程序主题']
            );

            $content->body(view($view, compact('theme_id','type')));
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function itemStore()
    {
        $data = [];

        if (2 == request('type')) {
            $param = str_replace(["\r\n", "\r", "\n", ' '], '', request('param'));

            $this->themeItemsRepository->create(['type' => 2, 'theme_id' => request('theme_id'), 'title' => request('title'), 'param' => $param]);

            return $this->api([], true);
        }

        if (1 == request('type')) {
            $data = $this->getParam();

            if (empty($data['param'])) {
                return $this->api([], false, 400, '自定义属性不能为空');
            }

            if ($this->themeItemsRepository->create($data)) {
                return $this->api([], true);
            }
        }

        return $this->api([], false);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemDelete($id)
    {
        if ($this->themeItemsRepository->delete($id)) {
            return $this->api([], true);
        }

        return $this->api([], false, 400, '删除失败');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getThemeApi()
    {
        $item = $this->themeTemplateRepository->getThemefirstByTemplateID(request('template_id'));

        if ($item) {
            return $this->api($item->theme_id, true);
        }

        return $this->api(0, true);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function operateThemeTemplate()
    {
        $template_id = request('template_id');

        $theme_id = request('theme_id');

        $theme_template = $this->themeTemplateRepository->operateThemeTemplate($template_id, $theme_id);

        if (!$theme_template) {
            return $this->api([], false);
        }

        return $this->api([], true);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDefaultTheme()
    {
        $theme_id = request('theme_id');

        $type = request('type');

        $id = request('id');

        if ($this->themeItemsRepository->setDefaultTheme($id, $theme_id, $type)) {
            return $this->api([], true);
        }

        return $this->api([], false);
    }

    /**
     * @param $id
     *
     * @return ThemeRepository|ThemeRepository[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|string
     */
    public function export($id)
    {
        $theme = $this->themeRepository->getThemeInfoBy($id);

        if ($theme) {
            return $theme;
        }

        return '';
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $kuoname = $file->getClientOriginalExtension();

            if ('json' != $kuoname) {
                return $this->api([], false, 400, '文件类型不正确非.json文件');
            }

            $input = json_decode(file_get_contents($file->getRealPath()), true);

            try {
                DB::beginTransaction();

                if (count($input) > 0) {
                    $theme = $this->themeRepository->create(['name' => $input['name'].'-'.rand(0, 100)]);

                    if (isset($input['items']) and count($input['items'])) {
                        foreach ($input['items'] as $item) {
                            $this->themeItemsRepository->create(
                                [
                                    'theme_id' => $theme->id,
                                    'type' => $item['type'],
                                    'title' => $item['title'],
                                    'img' => $item['img'],
                                    'param' => $item['param'],
                                    'is_default' => $item['is_default'],
                                ]);
                        }
                    }

                    if (isset($input['bars']) and count($input['bars'])) {
                        foreach ($input['bars'] as $item) {
                            $this->themeItemsRepository->create(
                                [
                                    'theme_id' => $theme->id,
                                    'type' => $item['type'],
                                    'title' => $item['title'],
                                    'img' => $item['img'],
                                    'param' => $item['param'],
                                    'is_default' => $item['is_default'],
                                ]);
                        }
                    }
                }

                DB::commit();

                return $this->api([], true);
            } catch (\Exception $exception) {
                return $this->api([], false, 400, '导入失败,文件格式错误');
            }
        }

        return $this->api([], false, 400, '导入失败');
    }
}
