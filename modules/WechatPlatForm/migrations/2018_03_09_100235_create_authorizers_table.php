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

class CreateAuthorizersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('authorizers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appid', 100)->unique()->comment('AppId');
            $table->integer('service_type_info')->nullable()->comment('授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号');
            $table->integer('verify_type_info')->nullable()->comment('授权方认证类型');
            $table->string('refresh_token', 500)->nullable()->comment('刷新凭据');
            $table->text('func_info')->nullable()->comment('授权接口');
            $table->integer('client_id')->nullable()->default(0);
            $table->string('nick_name')->nullable();
            $table->string('head_img')->nullable();
            $table->string('user_name')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('qrcode_url')->nullable();
            $table->string('call_back_url')->nullable()->comment('公众号回调');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('authorizers');
    }
}
