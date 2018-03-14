<?php

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
        $call_back_url = request('call_back_url');
        if ($clientId = request('client_id') AND auth('clients')->user()->id==$clientId) {
            $res = $this->repository->getAuthorizersByClient($clientId);
            if (count($res) > 0 && ! empty($call_back_url)) {
                $this->repository->updateCallBackUrl($clientId, $call_back_url);
            }
            return $this->repository->getAuthorizersByClient($clientId);
        }
        return '';
    }

    public function update()
    {
        if (request('client_id') AND request('app_id') AND auth('clients')->user()->id==request('client_id')) {
            return $this->repository->updateDel(request('client_id'),request('app_id'));
        }
        return 0;
    }

}
