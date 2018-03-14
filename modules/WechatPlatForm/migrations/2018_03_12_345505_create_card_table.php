<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appid', 100)->comment('AppId');
            $table->string('card_id', 500)->nullable()->comment('会员卡ID');
            $table->string('code', 500)->nullable()->comment('code序列号');
            $table->string('openid', 500)->nullable()->comment('用户唯一标识');
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
        Schema::dropIfExists('card');
    }
}
