<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->post('/oauth/token', 'PlatformController@getToken');

// 引导用户进行公众号授权
$router->get('/platform/auth', 'PlatformController@auth');
// 引导用户进行小程序授权
$router->get('/platform/mini/auth', 'PlatformController@authMini');

// 授权成功提示页面
$router->get('/platform/auth/result', 'PlatformController@authResult')->name('component.auth.result');
// 引导用户进行OAuth授权
$router->get('/oauth', 'OAuthController@oauth')->middleware(['middleware' => 'parameter']);
// OAuth授权结果返回
$router->get('/', 'OAuthController@result')->name('oauth.result');
