<?php

namespace app\admin\model;

use app\lib\Utils;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;
use think\Model;

class User extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\User::class);
    }


}
