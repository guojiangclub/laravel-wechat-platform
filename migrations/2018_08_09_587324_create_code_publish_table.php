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

class CreateCodePublishTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('code_publish', function (Blueprint $table) {
            $table->increments('id');

            $table->string('appid')->comment('appid');

            $table->string('auditid')->comment('审核编号');

            $table->integer('status')->default(2)->comment('状态'); //审核状态，其中0为审核成功，1为审核失败，2为审核中 3已发布 4撤回审核

            $table->text('template')->comment('模板内容json格式');

            $table->text('theme')->nullable();

            $table->text('bars')->nullable();

            $table->text('ext_json')->nullable();

            $table->text('note')->nullable();

            $table->text('reason')->nullable(); //当status=1，审核被拒绝时，返回的拒绝原因

            $table->timestamp('audit_time')->nullable(); //提交审核时间

            $table->timestamp('withdraw_audit_time')->nullable(); //撤回审核时间

            $table->timestamp('audit_success_time')->nullable(); //审核成功时间

            $table->timestamp('release_time')->nullable(); //发布时间

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('code_publish');
    }
}
