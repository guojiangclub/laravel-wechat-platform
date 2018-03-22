<?php
namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 群发消息.
 */
class BroadcastController extends Controller
{

    protected $platform;

    public function __construct(

        PlatformService $platformService

    ) {

        $this->platform = $platformService;
    }


    /**
     * 群发.
     */
    public function send()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();
        // 授权
        $server=$this->platform->authorizeAPI($appid);

        $open_id=null;

        if(isset($data['open_id']) AND count($data['open_id'])>0){
            $open_id=$data['open_id'];
        }

        //调用接口
        switch ($data['type']) {
            case 'news':
                $result = $server->broadcasting->sendNews($data['media_id'], $open_id);
                break;
            case 'image':

                $result = $server->broadcasting->sendImage($data['media_id'], $open_id);
                break;
            case 'video':

                $result = $server->broadcasting->sendVideo($data['media_id'], $open_id);
                break;

            case 'voice':
                $result = $server->broadcasting->sendVoice($data['media_id'], $open_id);
                break;

            case 'text':
                $result = $server->broadcasting->sendText( $data['text'], $open_id);
                break;
            case 'card_id':
                $result = $server->broadcasting->sendCard($data['card_id'], $open_id);
                break;
        }
        // 返回JSON

        return $result;
    }


}
