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

class CreateThemeTemplateTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('theme_template', function (Blueprint $table) {

            $table->increments('id');

            $table->string('theme_id')->comment('主题组ID');

            $table->string('template_id')->comment('模板ID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('theme_template');
    }
}
