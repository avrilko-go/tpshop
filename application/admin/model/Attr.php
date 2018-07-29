<?php

namespace app\admin\model;

use think\Model;

class Attr extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Attr::class);
    }

    public function type()
    {
        return $this->belongsTo('Type','type_id','id');
    }
}
