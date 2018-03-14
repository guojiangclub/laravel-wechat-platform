<?php

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

        if(!auth('clients')->user()){
            throw new Exception('Unauthorised', 3);
        }
        return $next($request);
    }
}
