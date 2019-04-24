<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
        if (null == request('appid')) {
            throw new Exception('Required parameter missing', 2);
        }

        return $next($request);
    }
}
