<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->get('/', function () {
    dd(request()->header('appid'));
});

// 平台授权事件接收URL
$router->any('/notify', 'NotifyController@notifyPlatform');
// 公众号消息与事件接收URL
Route::any('/notify/{appid}', 'NotifyController@notifyAccount');

$router->group(['middleware' => 'client'], function () use ($router) {
    // 获取授权公众号或小程序列表
    $router->get('authorizers', 'AuthorizerController@index');
    //取消授权删除授权
    $router->any('del', 'AuthorizerController@update');
});

// --------------------------------- 获取OAuth用户信息-----------------------------------//
$router->group(['middleware' => ['client', 'parameter']], function () use ($router) {
    $router->group(['prefix' => 'oauth'], function ($router) {
        $router->get('/user', 'OAuthController@userinfo');
    });
});
// ---------------------------------粉丝-----------------------------------//
$router->group(['middleware' => ['client', 'parameter']], function () use ($router) {
    $router->group(['prefix' => 'fans'], function ($router) {
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

$router->group(['middleware' => ['client', 'parameter']], function () use ($router) {
    // --------------------------------用户组（标签）----------------------------//

    $router->group(['prefix' => 'fans/group'], function ($router) {
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

    $router->group(['prefix' => 'menu'], function ($router) {
        //查询已设置菜单
        $router->get('/lists', 'MenuController@getAll');
        //获取当前菜单
        $router->get('/current', 'MenuController@getCurrent');
        //添加菜单(包括个性化菜单).
        $router->post('/store', 'MenuController@store');
        //删除菜单
        $router->post('/delete', 'MenuController@delMenu');
        //测试个性化菜单
        $router->post('/match', 'MenuController@match');
    });

    // --------------------------------模板消息----------------------------//

    $router->group(['prefix' => 'notice'], function ($router) {
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

    $router->group(['prefix' => 'qrcode'], function ($router) {
        //创建临时二维码
        $router->post('/temporary', 'QRCodeController@storeTemporary');
        //创建永久二维码
        $router->post('/forever', 'QRCodeController@storeForever');
        //获取二维码网址
        $router->post('/url', 'QRCodeController@getUrl');
    });

    // --------------------------------短网址服务----------------------------//

    $router->group(['prefix' => 'shorten'], function ($router) {
        //创建临时二维码
        $router->post('/get', 'ShortenController@shorten');
    });

    // --------------------------------群发----------------------------//

    $router->group(['prefix' => 'broadcast'], function ($router) {
        //群发发送消息
        $router->post('/send', 'BroadcastController@send');
    });

    // ---------------------------获取jsapi_ticket----------------------------//

    $router->group(['prefix' => 'js'], function ($router) {
        $router->get('/ticket', 'JsController@ticket');

        $router->get('/config', 'JsController@config');
    });

    // ---------------------------客服----------------------------//

    $router->group(['prefix' => 'staff'], function ($router) {
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

    // ---------------------------素材----------------------------//

    $router->post('/media/upload/image', 'MediasController@RemoteImage');

    $router->group(['prefix' => 'medias'], function ($router) {
        //上传图片素材
        $router->post('/remote/image', 'MediasController@RemoteImage');
        //上传图文消息图片
        $router->post('/remote/article/image', 'MediasController@RemoteArticleImage');
        //上传缩略图用于视频封面或者音乐封面
        $router->post('/remote/thumb/image', 'MediasController@RemoteThumbImage');
        //上传视频素材
        $router->post('/remote/video', 'MediasController@RemoteVideo');
        //上传音频素材
        $router->post('/remote/voice', 'MediasController@RemoteVoice');
        //删除永久素材
        $router->post('/delete', 'MediasController@delete');
        //上传永久图文消息
        $router->post('/remote/article', 'MediasController@RemoteArticle');
        //修改图文素材
        $router->post('/update/article', 'MediasController@updateArticle');
        //获取素材通过mediaId.
        $router->post('/get', 'MediasController@get');
        //获取永久素材列表
        $router->post('/lists', 'MediasController@getLists');
        //获取素材计数
        $router->get('/stats', 'MediasController@stats');
    });

    // ---------------------------优惠券和除会员卡外其他卡券----------------------------//
    $router->group(['prefix' => 'coupon'], function ($router) {
        //创建卡券
        $router->post('/create', 'CouponController@create');
        //创建货架
        $router->post('/landing-page/create', 'CouponController@createLandingPage');
        //获取卡券颜色
        $router->get('/colors', 'CouponController@getColors');
        //设置测试白名单
        $router->post('/setTestWhitelist', 'CouponController@setTestWhitelist');
        //创建二维码
        $router->post('/QRCode', 'CouponController@QRCode');
        //ticket 换取二维码链接
        $router->post('/getQrCodeUrl', 'CouponController@getQrCodeUrl');
        //查看卡券详情
        $router->post('/getinfo', 'CouponController@getInfo');
        //更改卡券信息
        $router->post('/update', 'CouponController@update');
        //更改卡券库存接口.
        $router->post('/update/quantityt', 'CouponController@updateQuantity');
        //设置卡券失效
        $router->post('/disable', 'CouponController@disable');
        //删除卡券
        $router->post('/delete', 'CouponController@delete');
        //查询code
        $router->post('/getCode', 'CouponController@getCode');
        //核销Code
        $router->post('/consumeCode', 'CouponController@consumeCode');
    });

    // ---------------------------会员卡----------------------------//
    $router->group(['prefix' => 'card'], function ($router) {
        //上传会员卡背景图
        $router->post('/card/upload/image', 'MediasController@RemoteCardImage');
        //创建会员卡
        $router->post('/create', 'CardController@create');
        //查看会员卡详情
        $router->post('/getinfo', 'CardController@getCard');
        //创建货架
        $router->post('/landing-page/create', 'CardController@createLandingPage');
        //激活会员卡
        $router->post('/membership/activate', 'CardController@membershipActivate');
        //更新会员信息.
        $router->post('/membership/update', 'CardController@membershipUpdate');
        //删除卡券
        $router->post('/delete', 'CardController@delete');
        //获取卡券颜色
        $router->get('/colors', 'CardController@getColors');
//        //获取会员信息
//        $router->post('/membership/get', 'CardController@setTestWhitelist');
        //设置测试白名单
        $router->post('/setTestWhitelist', 'CardController@setTestWhitelist');
        //创建二维码
        $router->post('/QRCode', 'CardController@QRCode');
        //更改会员卡券信息
        $router->post('/update/member_card', 'CardController@updateCard');
        // 拉取会员信息
        $router->post('/membership/get', 'CardController@membershipGet');
        //更改会员卡库存
        $router->post('/update/quantityt', 'CardController@updateQuantity');
        //设置会员卡券失效
        $router->post('/disable', 'CardController@disable');
        //checkCode
        $router->post('/getCode', 'CardController@getCode');
    });

    // ---------------------------数据统计与分析----------------------------//
    $router->group(['prefix' => 'data'], function ($router) {
        $router->get('/{str}', 'DataController@DataCube');
    });

    // ----------------------------小程序相关----------------------//
    $router->group(['middleware' => ['client', 'parameter'], 'prefix' => 'mini', 'namespace' => 'MiniProgram'], function () use ($router) {
//        //小程序修改服务器地址
//        $router->group(['prefix' => 'domain'], function ($router) {
//            //设置小程序服务器域名
//            $router->post('/modify', 'DomainController@modify');
//            //设置小程序业务域名（仅供第三方代小程序调用）
//            $router->post('/setWebviewDomain', 'DomainController@setWebviewDomain');
//
//        });

        //体验成员管理
        $router->group(['prefix' => 'tester'], function ($router) {
            //获取体验者列表
            $router->get('/list', 'TesterController@list');
            //绑定微信用户为小程序体验者
            $router->post('/bind', 'TesterController@bind');
            //解除绑定小程序的体验者
            $router->post('/unbind', 'TesterController@unbind');
        });

        //小程序代码管理
        $router->group(['prefix' => 'code'], function ($router) {
            //为授权的小程序帐号上传小程序代码
            $router->post('/commit', 'CodeController@commit');
            //获取体验小程序的体验二维码
            $router->post('/getQrCode', 'CodeController@getQrCode');
            //获取授权小程序帐号的可选类目
            $router->get('/getCategory', 'CodeController@getCategory');
            //获取小程序的第三方提交代码的页面配
            $router->get('/getPage', 'CodeController@getPage');
            //将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）
            $router->post('/submitAudit', 'CodeController@submitAudit');
            //获取审核结果
            $router->get('/getAuditStatus', 'CodeController@getAuditStatus');
            //查询最新一次提交的审核状态（仅供第三方代小程序调用）
            $router->get('/getLatestAuditStatus', 'CodeController@getLatestAuditStatus');
            //发布已通过审核的小程序（仅供第三方代小程序调用）
            $router->get('/release', 'CodeController@release');
            //小程序审核撤回
            $router->get('/withdrawAudit', 'CodeController@withdrawAudit');
            //小程序版本回退
            $router->get('/rollbackRelease', 'CodeController@rollbackRelease');
            //修改小程序线上代码的可见状态
            $router->post('/changeVisitStatus', 'CodeController@changeVisitStatus');
            //分阶段发布接口
            $router->post('/grayRelease', 'CodeController@grayRelease');
            //取消分阶段发布
            $router->get('/revertGrayRelease', 'CodeController@revertGrayRelease');
            //查询当前分阶段发布详情
            $router->get('/getGrayRelease', 'CodeController@getGrayRelease');
        });

        //小程序模板消息设置
        $router->group(['prefix' => 'template_message'], function ($router) {
            //获取小程序模板库标题列表
            $router->post('/list', 'TemplateMessageController@list');
            //获取模板库某个模板标题下关键词库
            $router->post('/get', 'TemplateMessageController@get');
            //组合模板并添加至帐号下的个人模板库
            $router->post('/add', 'TemplateMessageController@add');
            //删除帐号下的某个模板
            $router->post('/delete', 'TemplateMessageController@delete');
            //获取帐号下已存在的模板列表
            $router->post('/getTemplates', 'TemplateMessageController@getTemplates');
            //发送小程序模板消息
            $router->post('/send', 'TemplateMessageController@send');
        });

        //小程序基础接口
        $router->group(['prefix' => 'base'], function ($router) {
            //根据jsCode获取用户session信息
            $router->post('/session', 'BaseController@session');
        });

        //数据统计与分析
        $router->group(['prefix' => 'data'], function ($router) {
            $router->get('/{str}', 'BaseController@DataCube');
        });

        //获取小程序码
        $router->group(['prefix' => 'app_code'], function ($router) {
            //永久有效适用于需要的码数量较少的业务场景
            $router->post('/get', 'AppCodeController@get');
            //小程序码适用于需要的码数量极多，或仅临时使用的业务场景
            $router->post('/getUnlimit', 'AppCodeController@getUnlimit');
            //获取小程序二维码
            $router->post('/getQrCode', 'AppCodeController@getQrCode');
        });

        //客服
        $router->group(['prefix' => 'staff'], function ($router) {
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

        //微信小程序消息解密
        $router->group(['prefix' => 'decrypted'], function ($router) {
            $router->post('/', 'BaseController@decryptedData');
        });
    });
});
