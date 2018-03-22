<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeAndMIniInfoToAuthorizersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authorizers', function (Blueprint $table) {
            $table->dropColumn(['type','mini_info']);
        });
    }
}
