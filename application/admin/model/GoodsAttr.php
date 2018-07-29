<?php

namespace app\admin\model;

use think\Model;

class GoodsAttr extends Model
{
    public function attr()
    {
        return $this->belongsTo('Attr','attr_id','id')->setEagerlyType(0);
    }
}
