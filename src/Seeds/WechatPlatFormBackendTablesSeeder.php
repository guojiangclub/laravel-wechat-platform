<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WechatPlatFormBackendTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $lastOrder = DB::table(config('admin.database.menu_table'))->max('order');

        $parent = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => '微信第三方平台管理',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/customers',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        $customers = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent,
            'order' => $lastOrder++,
            'title' => '客户管理',
            'icon' => 'fa-user',
            'blank' => 1,
            'uri' => '',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $customers,
            'order' => $lastOrder++,
            'title' => '客户列表',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/customers',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        $wechats = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent,
            'order' => $lastOrder++,
            'title' => '公众号管理',
            'icon' => 'fa-comments-o',
            'blank' => 1,
            'uri' => '',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $wechats,
            'order' => $lastOrder++,
            'title' => '公众号列表',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/wechat?type=1',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        $minis = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent,
            'order' => $lastOrder++,
            'title' => '小程序管理',
            'icon' => 'fa-bars',
            'blank' => 1,
            'uri' => '',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $minis,
            'order' => $lastOrder++,
            'title' => '小程序列表',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/wechat?type=2',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $minis,
            'order' => $lastOrder++,
            'title' => '服务器域名',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/mini/domain',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $minis,
            'order' => $lastOrder++,
            'title' => '小程序模板',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/mini/template?type=1',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $minis,
            'order' => $lastOrder++,
            'title' => '小程序主题',
            'icon' => '',
            'blank' => 1,
            'uri' => 'wechat_platform/mini/theme',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
