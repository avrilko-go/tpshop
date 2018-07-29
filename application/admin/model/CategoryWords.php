<?php

namespace app\admin\model;

use think\Model;

class CategoryWords extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\CategoryWords::class);
    }

    public function category()
    {
        return $this->belongsTo('Category','category_id','id');
    }
}
