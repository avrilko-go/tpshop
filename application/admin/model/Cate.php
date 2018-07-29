<?php

namespace app\admin\model;

use think\facade\Request;
use think\Model;

class Cate extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Cate::class);
    }

    //文章分类增加
    public static function storeCate()
    {
        $data=Request::only(['cate_name','keywords','description','pid','show_nav']);
        $cate=self::create($data);
        return $cate->id ? true :false;
    }

    //文章分类更新
    public function updateCate()
    {
        $data=Request::only(['cate_name','keywords','description','pid','show_nav']);
        return $this->save($data) ? true : false;
    }

    public function article()
    {
        return $this->hasMany('Article','cate_id','id');
    }

    public function child(){
        return $this->hasMany('Cate','pid','id');
    }


}
