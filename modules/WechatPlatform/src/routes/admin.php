<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->group(['prefix' => 'wechat_platform'], function ($router) {
    $router->post('/upload', 'UploadController@index')->name('admin.wechat.mini.upload');

    $router->group(['prefix' => 'customers'], function ($router) {
        $router->get('/', 'CustomerController@index')->name('admin.customers.list');

        $router->post('/store', 'CustomerController@store')->name('admin.customers.store');

        $router->post('/{id}/delete', 'CustomerController@destroy')->name('admin.customers.delete');
    });

    $router->group(['prefix' => 'wechat'], function ($router) {
        $router->get('/', 'WechatController@index')->name('admin.wechat.list');

        $router->post('/{id}/delete', 'WechatController@destroy')->name('admin.wechat.delete');
    });

    //小程序管理
    $router->group(['prefix' => 'mini'], function ($router) {
        //小程序代码模版库管理
        $router->group(['prefix' => 'template'], function ($router) {
            $router->get('/', 'CodeTemplateController@getLists')->name('admin.mini.template.lists');

            $router->post('/store', 'CodeTemplateController@store')->name('admin.mini.template.store');

            $router->post('/{id}/delete', 'CodeTemplateController@delete')->name('admin.mini.template.delete');

            $router->post('/settingsTemplate', 'CodeTemplateController@settingsTemplate')->name('admin.mini.template.settingsTemplate');
        });

        //小程序体验者管理
        $router->group(['prefix' => 'tester'], function ($router) {
            $router->get('/', 'TesterController@getLists')->name('admin.mini.tester.lists');

            $router->post('/store', 'TesterController@store')->name('admin.mini.tester.store');

            $router->post('/{id}/delete', 'TesterController@delete')->name('admin.mini.tester.delete');
        });

        //修改服务器地址
        $router->group(['prefix' => 'domain'], function ($router) {
            $router->get('/', 'DomainController@index')->name('admin.mini.domain.index');

            $router->post('/store', 'DomainController@store')->name('admin.mini.domain.store');
        });

        //发布
        $router->group(['prefix' => 'send'], function ($router) {
            $router->get('/', 'MiniProgramController@index')->name('admin.mini.send.index');

            $router->get('/getQrCode', 'CodeController@getQrCode')->name('admin.mini.code.getQrCode');

            $router->get('/log', 'CodeController@log')->name('admin.mini.code.log');

            $router->get('/model', 'MiniProgramController@Model')->name('admin.mini.code.model');
        });

        $router->group(['prefix' => 'code'], function ($router) {
            $router->get('/getQrCode', 'CodeController@getQrCode')->name('admin.mini.code.getQrCode');

            $router->get('/getAppQrCode', 'CodeController@getAppQrCode')->name('admin.mini.code.getAppQrCode');

            $router->post('/commit', 'CodeController@commit')->name('admin.mini.code.commit');

            $router->post('/submitAudit', 'CodeController@submitAudit')->name('admin.mini.code.submitAudit');

            $router->post('/withdrawAudit', 'CodeController@withdrawAudit')->name('admin.mini.code.withdrawAudit');

            $router->post('/release', 'CodeController@release')->name('admin.mini.code.release');

            $router->post('/Reexamination', 'CodeController@Reexamination')->name('admin.mini.code.Reexamination');
        });

        $router->group(['prefix' => 'theme'], function ($router) {
            $router->get('/api', 'ThemeController@getThemeApi')->name('admin.mini.theme.api');

            $router->get('/', 'ThemeController@index')->name('admin.mini.theme.index');

            $router->post('/{id}/delete', 'ThemeController@delete')->name('admin.mini.theme.delete');

            $router->post('/store', 'ThemeController@store')->name('admin.mini.theme.store');

            $router->get('/{id}/export', 'ThemeController@export')->name('admin.mini.theme.export');

            $router->get('/{id}/item/export', 'ThemeController@exportItem')->name('admin.mini.theme.item.export');

            $router->post('/upload', 'ThemeController@upload')->name('admin.mini.theme.upload');

            $router->post('/upload/item', 'ThemeController@uploadItem')->name('admin.mini.theme.upload.item');

            $router->post('/update', 'ThemeController@update')->name('admin.mini.theme.update');

            $router->get('/item', 'ThemeController@items')->name('admin.mini.theme.item');

            $router->get('/{id}/item/edit', 'ThemeController@itemEdit')->name('admin.mini.theme.item.edit');

            $router->post('/{id}/item/update', 'ThemeController@itemUpdate')->name('admin.mini.theme.item.update');

            $router->get('/item/create', 'ThemeController@itemCreate')->name('admin.mini.theme.item.create');

            $router->post('/item/store', 'ThemeController@itemStore')->name('admin.mini.theme.item.store');

            $router->post('/{id}/item/delete', 'ThemeController@itemDelete')->name('admin.mini.theme.item.delete');

            $router->post('/operateThemeTemplate', 'ThemeController@operateThemeTemplate')->name('admin.mini.theme.operateThemeTemplate');

            $router->post('/setDefaultTheme', 'ThemeController@setDefaultTheme')->name('admin.mini.theme.setDefaultTheme');
        });
    });
});
