<?php

namespace app\admin\model;

use think\Model;

class Nav extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Nav::class);
    }
}
