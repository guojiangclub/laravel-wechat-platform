<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauth2TokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth2_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appid', 100)->comment('AppId');
            $table->string('openid', 500)->comment('用户唯一标识');
            $table->string('access_token', 500)->nullable()->comment('调用凭据');
            $table->string('refresh_token', 500)->nullable()->comment('刷新凭据');
            $table->string('scope', 500)->nullable()->comment('用户授权的作用域');
            $table->integer('expires_in')->nullable()->comment('access_token接口调用凭证超时时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('oauth2_tokens');
    }
}
