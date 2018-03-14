<?php

namespace iBrand\Wechat\Platform\Services;

use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
//use EasyWeChat\Server\Guard;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\Video;
use EasyWeChat\Message\Article;
use EasyWeChat\Message\Raw;
//use iBrand\Wechat\Platform\Repositories\CardRepository;
use iBrand\Wechat\Platform\Repositories\AuthorizerRepository;
//use EasyWeChat\Staff\Staff;
use iBrand\Wechat\Platform\Services\PlatformService;



/**
 * 公众平台推送
 */
class MessageService
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    /**
     * 仓库.
     * @var
     */
    protected $repository;

    /**
     * 公众平台事件接口.
     * @var
     */
    protected $server;

    protected $authorizerRepository;

    private $staff;

    private $platformService;

    public function __construct(
//        CardRepository $repository,
//        Guard $server,
        AuthorizerRepository $authorizerRepository,
//        Staff $staff,
        PlatformService $platformService

    ) {
//        $this->repository = $repository;
//        $this->server = $server;
        $this->authorizerRepository = $authorizerRepository;
//        $this->staff=$staff;
        $this->platformService=$platformService;
    }

    /**
     * 平台授权事件处理.
     *
     * @return string
     */
    public function accountEventProcess($appid)
    {
        $url = $this->authorizerRepository->getCallBackUrl($appid);
        $this->server->setMessageHandler(function ($message) use ($appid, $url) {
            //            return json_encode($message);
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        $key = isset($message->EventKey) ? $message->EventKey : '';
                        $ticket = isset($message->Ticket) ? $message->Ticket : '';
                        $params = [
                            'app_id'=>$appid,
                            'openid'=>$message->FromUserName,
                            'event_type'=>'subscribe',
                            'key'=>$key,
                            'ticket'=>$ticket,
                        ];

                        return $this->callBackEvent($url, $params);
                        break;
                    case 'unsubscribe':
                        $params = [
                            'app_id'=>$appid,
                            'openid'=>$message->FromUserName,
                            'event_type'=>'unsubscribe',
                        ];

                        return $this->callBackEvent($url, $params);
                        break;
                    case 'user_get_card':
                        $params = [
                            'app_id'=>$appid,
                            'open_id'=>$message->FromUserName,
                            'event_type'=>'user_get_card',
                            'card_id'=>$message->CardId,
                            'code'=>$message->UserCardCode,
                        ];

                        return $this->callBackEvent($url, $params);
                        break;
//                        $card = $this->repository->createCard($appid, $message->CardId, $message->UserCardCode, $message->FromUserName);
//                        $card->save();
//                        break;
                    case 'user_del_card':
                        $params = [
                            'app_id'=>$appid,
                            'open_id'=>$message->FromUserName,
                            'event_type'=>'user_del_card',
                            'card_id'=>$message->CardId,
                            'code'=>$message->UserCardCode,
                        ];
                        return $this->callBackEvent($url, $params);
                    case 'user_consume_card':
                        $params = [
                            'app_id'=>$appid,
                            'open_id'=>$message->FromUserName,
                            'event_type'=>'user_consume_card',
                            'card_id'=>$message->CardId,
                            'code'=>$message->UserCardCode,
                        ];
                        return $this->callBackEvent($url, $params);

                    case 'user_view_card':
                        $params = [
                            'app_id'=>$appid,
                            'open_id'=>$message->FromUserName,
                            'event_type'=>'user_view_card',
                            'card_id'=>$message->CardId,
                            'code'=>$message->UserCardCode,
                        ];
                        return $this->callBackEvent($url, $params);

                    case 'SCAN':
                        $params = [
                            'app_id'=>$appid,
                            'openid'=>$message->FromUserName,
                            'event_type'=>'SCAN',
                            'key'=>$message->EventKey,
                            'ticket'=>$message->Ticket,
                        ];

                        return $this->callBackEvent($url, $params);
                        break;

                    case 'CLICK':
                        $params = [
                            'app_id'=>$appid,
                            'open_id'=>$message->FromUserName,
                            'event_type'=>'CLICK',
                            'key'=>$message->EventKey,
                        ];
//                        return $this->BackMessage(['type'=>'card','card_id'=>'poGxkwkjK8iVzLFM0dlVn2zk85qc','app_id'=>$appid,'open_id'=>$message->FromUserName]);
                        return $this->callBackEvent($url, $params);
                        break;
                    //全网发布测试：事件
                    case 'LOCATION':
                        return 'LOCATIONfrom_callback';
//                    点击事件
                }
            }
            if ($message->MsgType == 'text') {
                //全网发布测试：文本消息
                if ($message->Content == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
                    return 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
                }
                $params = [
                    'app_id'=>$appid,
                    'open_id'=>$message->FromUserName,
                    'type'=>$message->MsgType,
                    'content'=>$message->Content,
                ];
                $data = $this->BackCurl($url.'/wechat_call_back/message', $method = self::GET, $params);



                return $this->BackMessage($data);
            }

            return '';
        });

        //全网发布测试：调用接口
        $message = $this->server->getMessage();
        if ($message['MsgType'] == 'text' && strstr($message['Content'], 'QUERY_AUTH_CODE:')) {
            return $message['Content'];
        }

        return $this->server->serve();
    }

    /**
     * 获取会员卡code.
     *
     * @param $appid
     * @param $card_id
     * @param $openid
     * @return string
     */
    public function getCode($appid, $card_id, $openid)
    {
        return $this->repository->getCode($appid, $card_id, $openid);
    }

    public function BackCurl($url, $method = self::GET, $params = [], $request_header = [])
    {
        $request_header = ['Content-Type' => 'application/x-www-form-urlencoded'];
        if ($method === self::GET || $method === self::DELETE) {
            $url .= (stripos($url, '?') ? '&' : '?').http_build_query($params);
            $params = [];
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
        if ($method === self::POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output, true);
    }

    // 消息回复
    public function BackMessage($data)
    {
        if(count($data)>0){
            foreach ($data  as $k=>$item){
                if(!empty($item) And isset($item['type'])){
                    //授权
                    $this->platformService->authorizeAPI($this->staff,$item['app_id']);
                    $message='';
                    switch ($item['type']) {
                        case 'text':
                            $message='{
                                  "touser":"'.$item['open_id'].'",
                                  "msgtype":"text",
                                  "text":{
                                           "content":"'.$item['content'].'",
                                   },
                                }';
                            break;
                        case 'image':
                            $message='{
                                  "touser":"'.$item['open_id'].'",
                                  "msgtype":"image",
                                  "image":{
                                           "media_id":"'.$item['media_id'].'",
                                   },
                                }';
                            break;
                        case 'voice':

                            break;
                        case 'video':
                            $message='{
                                  "touser":"'.$item['open_id'].'",
                                  "msgtype":"video",
                                  "video":{
                                           "media_id":"'.$item['media_id'].'",
                                            "thumb_media_id":"'.$item['thumb_media_id'].'",
                                            "title":"'.$item['title'].'",
                                            "description":"'.$item['description'].'",
                                   },
                                }';
                            break;
                        case 'article':
                            $news = new News([
                                'title'       =>$item['title'],
                                'description' =>$item['description'],
                                'url'         =>$item['url'],
                                'image'       => $item['image'],
                            ]);
                            return $news;
                        case 'card':
                            $message='{
                                  "touser":"'.$item['open_id'].'",
                                  "msgtype":"wxcard",
                                  "wxcard":{
                                           "card_id":"'.$item['card_id'].'",
                                   },
                                }';
                            break;

                        // ... 其它消息
                        default:
                            return '';
                            break;
                    }

                    $result = $this->staff->send($message);

                }



            }
        }

    }



    // K事件处理
    public function callBackEvent($url, $data)
    {
        $data = $this->BackCurl($url.'/wechat_call_back/event', $method = self::GET, $data);
        \Log::info($data);
        return $this->BackMessage($data);
    }
}
