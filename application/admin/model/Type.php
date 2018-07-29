<?php

namespace app\admin\model;

use think\Model;

class Type extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Type::class);
    }
}
