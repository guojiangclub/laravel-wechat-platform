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

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function admin_wechat_api($res, $data = [])
    {
        if (isset($res['errcode']) and isset($res['errmsg']) and 0 != $res['errcode']) {
            $errcode = config('mini_program_errcode');

            $message = isset($errcode[$res['errcode']]) ? $errcode[$res['errcode']] : 'errcode:'.$res['errcode'].'errmsg:'.$res['errmsg'];

            return $this->api($data, false, 400, $message);
        }

        return $this->api($data, true);
    }

    public function api($data = [], $status = true, $code = 200, $message = '')
    {
        return response()->json(
            ['status' => $status, 'code' => $code, 'message' => $message, 'data' => $data]);
    }
}
