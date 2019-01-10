<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Models;

use Illuminate\Database\Eloquent\Model;

class CodePublish extends Model
{
    const SUCCESS_STATUS = 0; //审核成功

    const ERROR_STATUS = 1; //审核失败

    const AUDIT_STATUS = 2; //待审核

    const PUBLISH_STATUS = 3; //已发布

    const WITHDRW_STATUS = 4; //审核撤回

    protected $table = 'code_publish';

    protected $guarded = ['id'];
}
