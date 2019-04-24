<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Repositories\AuthorizerRepository;

class AuthorizerController extends Controller
{
    protected $repository;

    public function __construct(
        AuthorizerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $type = request('type') ? request('type') : 1;
        $call_back_url = request('call_back_url');
        if ($clientId = request('client_id') and auth('clients')->user()->id == $clientId) {
            $res = $this->repository->getAuthorizersByClient($clientId, $type);
            if (count($res) > 0 && !empty($call_back_url)) {
                $this->repository->updateCallBackUrl($clientId, $call_back_url);
            }

            return $this->repository->getAuthorizersByClient($clientId, $type);
        }

        return null;
    }

    /**
     * @return int
     */
    public function update()
    {
        if (request('client_id') and request('app_id') and auth('clients')->user()->id == request('client_id')) {
            return $this->repository->updateDel(request('client_id'), request('app_id'));
        }

        return 0;
    }
}
