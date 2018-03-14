<?php

namespace iBrand\Wechat\Platform\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clients  extends Authenticatable
{

    use HasApiTokens,Notifiable;
    protected $table = 'oauth_clients';
    protected $guarded = ['id'];

}
