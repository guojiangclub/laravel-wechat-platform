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
use iBrand\Wechat\Platform\Models\Clients;
use iBrand\Wechat\Platform\Repositories\ClientsRepository as AdminClientsRepository;
use Laravel\Passport\ClientRepository;

class CustomerController extends Controller
{
    protected $clientRepository;

    protected $adminClientsRepository;

    public function __construct(ClientRepository $ClientRepository, AdminClientsRepository $adminClientsRepository)
    {
        $this->clientRepository = $ClientRepository;

        $this->adminClientsRepository = $adminClientsRepository;
    }

    /**
     * @return Content
     */
    public function index()
    {
        $limit = request('limit') ? request('limit') : 20;

        $name = request('name');

        $customers = $this->adminClientsRepository->getListsByname($name, $limit);

        return LaravelAdmin::content(function (Content $content) use ($customers) {
            $content->header('客户列表');

            $content->breadcrumb(
                ['text' => '客户管理', 'url' => 'customers', 'no-pjax' => 1],
                ['text' => '客户列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '客户列表']
            );

            $content->body(view('wechat-platform::customer.index', compact('customers')));
        });
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $name = request('name');

        if (!$name || Clients::where('name', $name)->first()) {
            return $this->api([], false, 400, 'name已存在');
        }

        if ($this->clientRepository->create(null, $name, 'http://localhost', $personalAccess = false, $password = true)) {
            return $this->api([], true);
        }

        return $this->api([], false);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $client = Clients::find($id);

        if ($client->wechat->count() || $client->mini->count()) {
            return $this->api([], false, 400, '有关联公众号或小程序删除失败');
        }

        Clients::destroy($id);

        return $this->api([], true);
    }
}
