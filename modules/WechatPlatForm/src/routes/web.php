<?php

$router->get('/',function (){
        return view('welcome');
});


//获取Token
$router->post('/oauth/token','PlatformController@getToken');

// 引导用户进行公众号授权
$router->get('/platform/auth','PlatformController@auth');
// 授权成功提示页面
$router->get('/platform/auth/result','PlatformController@authResult')->name('component.auth.result');








