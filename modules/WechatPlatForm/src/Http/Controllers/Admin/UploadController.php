<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers\Admin;

use Illuminate\Http\Request;
use iBrand\Wechat\Platform\Http\Controllers\Controller;
use iBrand\Wechat\Platform\Repositories\ThemeItemsRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadController.
 */
class UploadController extends Controller
{
    protected $themeItemsRepository;

    public function __construct(

        ThemeItemsRepository $themeItemsRepository
    )
    {
        $this->themeItemsRepository = $themeItemsRepository;

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {


        $file = $request->file('file');

        if ($file) {

            $kuoname = $file->getClientOriginalExtension();

            $path = $file->getRealPath();

            $filename = 'public' . '/' . uniqid() . '.' . $kuoname;

            $bool = Storage::disk('local')->put($filename, file_get_contents($path));

            $url = get_host() . Storage::url($filename);

            return $this->api($url, true, 200, '');
        }

        return $this->api([], false, 400, '');


    }


}
