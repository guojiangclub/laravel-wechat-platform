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

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Clients extends Authenticatable
{
    use HasApiTokens,Notifiable;
    protected $table = 'oauth_clients';
    protected $guarded = ['id'];

    public function wechat()
    {
        return $this->hasMany(Authorizer::class, 'client_id')->where('type', 1);
    }

    public function mini()
    {
        return $this->hasMany(Authorizer::class, 'client_id')->where('type', 2);
    }
}
