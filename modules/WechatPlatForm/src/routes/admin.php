<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->group(['prefix' => 'customers', 'namespace' => 'Admin'], function ($router) {
    $router->get('/', 'CustomerController@index')->name('admin.customers.list');

    $router->post('/store', 'CustomerController@store')->name('admin.customers.store');

    $router->post('/{id}/delete', 'CustomerController@destroy')->name('admin.customers.delete');

    $router->group(['prefix' => 'wechat'], function ($router) {
        $router->get('/', 'WechatController@index')->name('admin.customers.wechat.list');

        $router->post('/{id}/delete', 'WechatController@destroy')->name('admin.customers.wechat.delete');
    });
});
