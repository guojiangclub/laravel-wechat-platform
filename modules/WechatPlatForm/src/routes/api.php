<?php

$router->get('/',function (){
    dd('api');
});

// 平台授权事件接收URL
$router->any('/notify','NotifyController@notifyPlatform');
// 公众号消息与事件接收URL
Route::any('/notify/{appid}', 'NotifyController@notifyAccount');



$router->group(['middleware'=>'client'],function () use($router){
     // 获取授权公众号列表
    $router->get('authorizers', 'AuthorizerController@index');
    //取消授权删除授权公众号
    $router->any('del', 'AuthorizerController@update');
});


// --------------------------------- 获取OAuth用户信息-----------------------------------//
$router->group(['middleware'=>['client','parameter']],function () use($router){
    $router->group(['prefix'=>'oauth'],function ($router){
        $router->get('/user', 'OAuthController@userinfo');
    });
});
// ---------------------------------粉丝-----------------------------------//
$router->group(['middleware'=>['client','parameter']],function () use($router){
    $router->group(['prefix'=>'fans'],function ($router){
        //获取粉丝列表
        $router->get('/lists', 'FansController@lists');
        //获取单个粉丝信息
        $router->post('/get', 'FansController@get');
        //修改粉丝备注
        $router->post('/remark', 'FansController@remark');
        //拉黑粉丝
        $router->post('/block', 'FansController@block');
        //取消拉黑粉丝
        $router->post('/unblock', 'FansController@unblock');
        //获取黑名单
        $router->get('/blacklist', 'FansController@blacklist');
    });
});


$router->group(['middleware'=>['client','parameter']],function () use($router){

// --------------------------------用户组（标签）----------------------------//

    $router->group(['prefix'=>'fans/group'],function ($router){
        //获取标签组列表
        $router->get('/lists', 'FansGroupController@lists');
        //创建标签组
        $router->post('/create', 'FansGroupController@create');
        //修改标签组
        $router->post('/update', 'FansGroupController@update');
        //删除标签组
        $router->post('/delete', 'FansGroupController@delete');
        //批量为用户移动标签
        $router->post('/moveUsers', 'FansGroupController@moveUsers');
        //批量为用户添加标签
        $router->post('/addUsers', 'FansGroupController@addUsers');
        //批量为用户移除标签
        $router->post('/delUsers', 'FansGroupController@delUsers');
        //获取标签下用户列表
        $router->post('/userList', 'FansGroupController@UserList');
    });

// --------------------------------菜单----------------------------//

    $router->group(['prefix'=>'menu'],function ($router){
        //查询已设置菜单
        $router->get('/lists', 'MenuController@getAll');
        //获取当前菜单
        $router->get('/current','MenuController@getCurrent');
        //添加菜单(包括个性化菜单).
        $router->post('/store', 'MenuController@store');
        //删除菜单
        $router->post('/delete', 'MenuController@delMenu');
        //测试个性化菜单
        $router->post('/match', 'MenuController@match');
    });



// --------------------------------模板消息----------------------------//

    $router->group(['prefix'=>'notice'],function ($router){
        //获取支持的行业列表
        $router->get('/getIndustry', 'NoticeController@getIndustry');
        //获取所有模板列表
        $router->get('/get', 'NoticeController@getTemplateAll');
        //发送模板消息
        $router->get('/send', 'NoticeController@send');
        //多用户发送模板消息
        $router->post('/sendall', 'NoticeController@sendAll');
        //添加模板
        $router->post('/addTemplate', 'NoticeController@addTemplate');
        //删除模板
        $router->post('/delete', 'NoticeController@delete');
    });


// --------------------------------二维码--------------------------------//

    $router->group(['prefix'=>'qrcode'],function ($router){
        //创建临时二维码
        $router->post('/temporary', 'QRCodeController@storeTemporary');
        //创建永久二维码
        $router->post('/forever', 'QRCodeController@storeForever');
        //获取二维码网址
        $router->post('/url', 'QRCodeController@getUrl');
    });

    // --------------------------------短网址服务----------------------------//

    $router->group(['prefix'=>'shorten'],function ($router){
        //创建临时二维码
        $router->post('/get', 'ShortenController@shorten');

    });

    // ---------------------------获取jsapi_ticket----------------------------//

    $router->group(['prefix'=>'js'],function ($router){

        $router->get('/ticket', 'JsController@ticket');

        $router->get('/config', 'JsController@config');

    });


    // ---------------------------客服----------------------------//

    $router->group(['prefix'=>'staff'],function ($router){
        //获取所有客服
        $router->get('/lists', 'StaffController@getLists');
        //获取所有在线的客服
        $router->get('/on_lines', 'StaffController@getOnLines');
        //添加客服
        $router->post('/create', 'StaffController@store');
        //修改客服
        $router->post('/update', 'StaffController@update');
        //删除客服
        $router->post('/delete', 'StaffController@delete');
        //获取客服与客户聊天记录
        $router->post('/messages', 'StaffController@messages');
        //设置客服头像
        $router->post('/setAvatar', 'StaffController@setAvatar');
        //主动发送消息给用户
        $router->post('/send/message', 'StaffController@sendMessage');
        //邀请微信用户加入客服
        $router->post('/invite', 'StaffController@invite');
        //创建会话
        $router->post('/session/create', 'StaffController@SessionCreate');
        //关闭会话
        $router->post('/session/close', 'StaffController@SessionClose');
        //获取客服会话列表
        $router->post('/session/list', 'StaffController@customerSsessionList');
        //获取未接入会话列表
        $router->post('/session/waiting/list', 'StaffController@customerSsessionWaiting');

    });














});





