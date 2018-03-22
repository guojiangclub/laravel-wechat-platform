<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use Exception;
use iBrand\Wechat\Platform\Services\MessageService;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 会员卡
 */
class CardController extends Controller
{

    protected $platform;

    public function __construct(

        PlatformService $platformService

    ) {

        $this->platform = $platformService;
    }


    /**
     * 创建会员卡
     */
    public function create()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //兼容以前代码
        if(isset($data['card']['member_card']['base_info'])){
            $baseInfo=$data['card']['member_card']['base_info'];
            $especial=isset($data['card']['member_card']['especial'])?$data['card']['member_card']['especial']:[];
        }else{
            $baseInfo=$data['base_info'];
            $especial=isset($data['especial'])?$data['especial']:[];
        }

        $attributes=array_merge(['base_info' => $baseInfo], $especial);

        //调用接口
        $result = $server->card->create('member_card',$attributes );

        //返回json
        return $result;
    }



    /**
     * 创建货架.
     */

    public function createLandingPage()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->createLandingPage($data['banner'], $data['page_title'], $data['can_share'], $data['scene'], $data['card_list']);

        //返回json
        return $result;
    }




    /**
     * 激活会员卡
     */

    public function membershipActivate()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->member_card->activate($data);

        // 返回json
        return $result;
    }




    /**
     * 更新会员信息.
     */

    public function membershipUpdate()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->member_card->updateUser($data);

        // 返回json
        return $result;
    }



    /**
     * 删除会员卡
     */

    public function delete()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->delete($data['card_id']);

        // 返回json
        return $result;
    }


    /**
     * 获取卡券颜色
     */

    public function getColors()
    {
        // 参数
        $appid = request('appid');
        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->colors();;

        return $result;
    }



    /**
     * 查看会员卡详情
     */

    public function getCard()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();
        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->get($data['card_id']);

        return $result;
    }


    /**
     * 设置测试白名单
     */

    public function setTestWhitelist()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->setTestWhitelist($data['openids']);

        return $result;
    }



    // 创建二维码
    public function QRCode()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->createQrCode($data['cards']);

        return $result;
    }




    /**
     * 更改会员卡券信息
     */

    public function updateCard()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        $baseInfo=$data['base_info'];

        $especial=isset($data['especial'])?$data['especial']:[];

        $attributes=array_merge(['base_info' => $baseInfo], $especial);

        //调用接口
        $result = $server->card->update($data['card_id'],'member_card',$attributes);

        return $result;
    }


    /**
     * 拉取会员信息接口
     */

    public function membershipGet()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();
        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->member_card->getUser($data['card_id'], $data['code']);

        // 返回json
        return $result;
    }


    /**
     * 更改库存接口
     */

    public function updateQuantity()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        if ($data['amount'] >= 0) {
            // 增加库存
            $result = $server->card->increaseStock($data['card_id'], $data['amount']);
        }

        if ($data['amount'] < 0) {
            // // 减少库存
            $result = $server->card->reductStock($data['card_id'], $data['amount']);
        }
        // 返回json
        return $result;
    }



    /**
     * 会员卡Code失效
     */

    public function disable()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->code->disable($data['code'], $data['card_id']);

        // 返回json
        return $result;
    }


    /**
     * 查询 Code 接口
     */

    public function getCode()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->code->get($data['code'], $data['card_id'],false);

        // 返回json
        return $result;
    }
}
