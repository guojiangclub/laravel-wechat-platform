<?php

/*
 * This file is part of ibrand/wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeItems extends Model
{
    protected $table = 'theme_items';

    protected $guarded = ['id'];
}
