<?php

namespace iBrand\Wechat\Platform\Http\Controllers;

use iBrand\Wechat\Platform\Services\PlatformService;
use EasyWeChat\Kernel\Messages\Article;
use Exception;

/**
 * 菜单.
 */
class MediasController extends Controller
{

    protected $platform;

    public function __construct(

        PlatformService $platformService

    ) {

        $this->platform = $platformService;
    }

    /**
     * 上传图片素材.
     */
    public function RemoteImage()
    {
        $appid = request('appid');

        $file = request()->file('image');

        if (empty($file)) {
            throw new Exception('cannot not find file.', 5);
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        //调用接口
        $result = $server->material->uploadImage('/tmp/'.$file->getClientOriginalName());

        return $result;
    }

    /**
     * 上传图文消息图片.
     */
    public function RemoteArticleImage()
    {
        $appid = request('appid');

        $file = request()->file('image');

        if (empty($file)) {
            throw new Exception('cannot not find file.', 5);
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        //调用接口
        $result = $server->material->uploadArticleImage('/tmp/'.$file->getClientOriginalName());

        if(isset($result['url']))  return $result['url'];

        return null;

    }

    /**
     * 上传缩略图用于视频封面或者音乐封面
     */
    public function RemoteThumbImage()
    {
        $appid = request('appid');

        $file = request()->file('image');


        if (empty($file)) {
            throw new Exception('cannot not find file.', 5);
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        //调用接口
        $result = $server->material->uploadThumb('/tmp/'.$file->getClientOriginalName());

        if(isset($result->url))  return $result->url;

        return null;
    }


    /**
     * 上传视频素材.
     */
    public function RemoteVideo()
    {
        $appid = request('appid');

        $file = request()->file('video');

        $title = request('title');

        $description = request('description');

        if (empty($file)) {
            throw new Exception('cannot not find file.', 5);
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        //调用接口
        $result = $server->material->uploadVideo('/tmp/'.$file->getClientOriginalName(), $title, $description);

        return $result;
    }


    /**
     * 上传音频素材.
     */
    public function RemoteVoice(){

        $appid = request('appid');

        $file = request()->file('video');

        if (empty($file)) {
            throw new Exception('cannot not find file.', 5);
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        //调用接口
        $result = $server->material->uploadVoice('/tmp/'.$file->getClientOriginalName());

        return $result;

    }


    /**
     * 删除永久素材.
     */
    public function delete()
    {
        $appid = request('appid');

        $data = request()->json()->all();

        $mediaId = $data['mediaId'];

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->material->delete($mediaId);

        return $result;
    }



    /**
     * 上传永久图文消息.
     */
    public function RemoteArticle()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        $article = [];

        if (count($data) == count($data, 1)) {
            $article = new Article($data);
        } else {
            foreach ($data as $item) {
                $article[] = new Article($item);
            }
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);
        //调用接口
        $result = $server->material->uploadArticle($article);

        return $result;
    }



    /**
     * 获取素材通过mediaId.
     */
    public function get()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->material->get($data['mediaId']);

        return $result;
    }

    /**
     * 获取永久素材列表.
     */
    public function getLists()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->material->list($data['type'], $data['offset'], $data['count']);

        return $result;
    }

    /**
     * 获取素材计数.
     */
    public function stats()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->material->stats();

        return $result;
    }

    /**
     * 修改图文素材.
     */
    public function updateArticle()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //调用接口

        if (isset($data['index'])) {
            $result = $server->material->updateArticle($data['mediaId'], $data['data'], $data['index']);
        } else {
            $result = $server->material->updateArticle($data['mediaId'], $data['data']);

        }

        \Log::info( $data['data']);
        return $result;
    }


    /**
     * 上传会员卡背景图片.
     */
    public function RemoteCardImage()
    {
        $appid = request('appid');

        $file = request()->file('image');

        if (empty($file)) {
            throw new Exception('cannot not find file.', 5);
        }

        // 授权
        $server=$this->platform->authorizeAPI($appid);

        //修改文件名
        rename($file->getPathname(), '/tmp/'.$file->getClientOriginalName());

        //调用接口
        $result = $server->material->uploadArticleImage('/tmp/'.$file->getClientOriginalName());

        return $result;

    }

}