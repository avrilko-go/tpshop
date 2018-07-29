<?php

namespace app\admin\model;

use think\Model;

class Product extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Product::class);
    }
}
