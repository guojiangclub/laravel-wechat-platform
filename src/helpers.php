<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

function FilterHttpsAndWss($http)
{
    if ($http) {
        $arr = explode('//', $http);
        $http = $arr[1];
    }

    return $http;
}

function get_host()
{
    $scheme = 'off' == $_SERVER['HTTPS'] ? 'http://' : 'https://';
    $url = $scheme.$_SERVER['HTTP_HOST'];

    return $url;
}

function is_color($str)
{
    $exp = '/^#([0-9a-fA-F]{6}|[0-9a-fA-F]{3})$/';

    return preg_match($exp, $str);
}
