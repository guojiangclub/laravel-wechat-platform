<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
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
 * Class ClientVerify.
 */
class ClientVerify
{
    public function handle($request, Closure $next)
    {
        if (!auth('clients')->user()) {
            throw new Exception('Unauthorised', 3);
        }

        return $next($request);
    }
}
