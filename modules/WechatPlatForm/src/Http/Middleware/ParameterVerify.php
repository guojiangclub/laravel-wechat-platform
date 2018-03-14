<?php

namespace iBrand\Wechat\Platform\Http\Middleware;

use Closure;
use Exception;

/**
 * 验证调用api的参数是否完整
 * Class ParameterVerify.
 */
class ParameterVerify
{
    public function handle($request, Closure $next)
    {
        if (request('appid') == null) {
            throw new Exception('Required parameter missing', 2);
        }
        return $next($request);
    }
}
