<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndMIniInfoToAuthorizersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('authorizers', function (Blueprint $table) {
            $table->tinyInteger('type')->default(1)->comment('1微信公众号2微信小程序');
            $table->text('mini_info')->nullable()->comment('小程序授权接口');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('authorizers', function (Blueprint $table) {
            $table->dropColumn(['type', 'mini_info']);
        });
    }
}
