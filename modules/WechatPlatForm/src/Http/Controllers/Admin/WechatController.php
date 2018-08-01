<?php

/*
 * This file is part of ibrand/wechat-platform.
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
use iBrand\Wechat\Platform\Models\Authorizer;
use iBrand\Wechat\Platform\Models\Clients;

class WechatController extends Controller
{
    /**
     * @return Content
     */
    public function index()
    {
        $customers = Clients::where('password_client', 1)->get();

        $client_id = request('client_id');

        $limit = request('limit') ? request('limit') : 20;

        $query = Authorizer::where('type', 1)->where('client_id', '<>', 0)->OrderBy('created_at', 'desc');

        if (null == !$client_id) {
            $query = $query->where('client_id', $client_id);
        }

        $lists = $query->paginate($limit);

        return LaravelAdmin::content(function (Content $content) use ($lists, $customers) {
            $content->header('公众号管理');

            $content->breadcrumb(
                ['text' => '公众号管理', 'url' => 'customers/wechat', 'no-pjax' => 1],
                ['text' => '公众号列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '公众号列表']
            );

            $content->body(view('wechat-platform::wechat.index', compact('lists', 'customers')));
        });
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($info = Authorizer::find($id)) {
            $info->client_id = 0;
            $info->save();

            return $this->api([], true);
        }

        return $this->api([], false, 400, '删除失败');
    }
}
