<?php

$router->get('/',function (){
    dd('api');
});

// 平台授权事件接收URL
$router->any('/notify','NotifyController@notifyPlatform');

$router->group(['middleware'=>'client'],function () use($router){
     // 获取授权公众号列表
    $router->get('authorizers', 'AuthorizerController@index');
    //取消授权删除授权公众号
    $router->any('del', 'AuthorizerController@update');
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

// --------------------------------用户组（标签）----------------------------//
$router->group(['middleware'=>['client','parameter']],function () use($router){
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
});



// --------------------------------菜单----------------------------//
$router->group(['middleware'=>['client','parameter']],function () use($router){
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
});
