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

class CreateTestersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('testers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('appid')->comment('appid');

            $table->string('wechatid')->comment('体验者微信号');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('testers');
    }
}
