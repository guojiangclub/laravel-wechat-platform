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

class CreateThemeItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('theme_items', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('type')->default(1)->comment('1配色主题2菜单主题');

            $table->string('title')->comment('标题');

            $table->integer('theme_id')->default(0)->comment('主题组ID');

            $table->string('img')->nullable()->comment('封面图');

            $table->integer('is_default')->default(0)->comment('默认主题');

            $table->text('param')->nullable()->comment('自定义参数');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('theme_items');
    }
}
