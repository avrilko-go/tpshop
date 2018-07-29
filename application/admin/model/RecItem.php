<?php

namespace app\admin\model;

use think\Model;

class RecItem extends Model
{
    public function category()
    {
        return $this->belongsTo('Category','value_id','id')->setEagerlyType(0);
    }

    public function goods()
    {
        return $this->belongsTo('Goods','value_id','id')->setEagerlyType(0);
    }
}
