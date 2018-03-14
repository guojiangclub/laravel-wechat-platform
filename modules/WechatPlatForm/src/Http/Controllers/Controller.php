<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function api($data = array(), $status = true, $code = 200, $message = '')
    {
        return response()->json(
            ['status' => $status
                , 'code' => $code
                , 'message' => $message
                , 'data' => $data]);
    }
}
