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

class Theme extends Model
{
    protected $table = 'theme';

    protected $guarded = ['id'];

    public function items(){

        return $this->hasMany(ThemeItems::class,'theme_id')->where('type',1);
    }

    public function bars(){

        return $this->hasMany(ThemeItems::class,'theme_id')->where('type',2);
    }

}


