<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->post('/oauth/token', 'PlatformController@getToken');

// 引导用户进行公众号授权
$router->get('/platform/auth', 'PlatformController@auth')->name('web.platform.auth');
// 引导用户进行小程序授权
$router->get('/platform/mini/auth', 'PlatformController@authMini')->name('web.platform.mini.auth');

// 授权成功提示页面
$router->get('/platform/auth/result', 'PlatformController@authResult')->name('component.auth.result');
// 引导用户进行OAuth授权
$router->get('/oauth', 'OAuthController@oauth')->middleware(['middleware' => 'parameter']);
// OAuth授权结果返回
$router->get('/', 'OAuthController@result')->name('oauth.result');

$router->get('/wx6f54b9a50feda087/test', function () {
    return response()->json(
        ['status' => true, 'code' => 200, 'message' => '', 'data' => []]);
});
