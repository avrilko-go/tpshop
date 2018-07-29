<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class CategoryAd extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\CategoryAd::class);
    }

    public function category()
    {
        return $this->belongsTo('Category','category_id','id');
    }

    public function getImgSrcAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }


    //增加左图关联
    public static function storeCategoryAd()
    {
        $file=Request::file('img_src');
        $data=Request::only(['position','link_url','category_id']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['img_src']=$path;
        }
        $categoryAd=self::create($data);
        return $categoryAd->id ? true : false;
    }

    //修改左图关联
    public function updateCategoryAd()
    {
        $file=Request::file('img_src');
        $data=Request::only(['position','link_url','category_id']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('img_src'));
            $this->img_src=$path;
        }
        return $this->save($data) ? true : false;
    }

}
