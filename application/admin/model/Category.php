<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class Category extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Category::class);
    }

    //商品分类增加
    public static function storeCategory()
    {
        $file=Request::file('cate_img');
        $data=Request::only(['cate_name','iconfont','description','pid','keywords','show_cate']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['cate_img']=$path;
        }

        $category=self::create($data);
        return $category->id ? true :false;
    }

    //商品分类更新
    public function updateCategory()
    {
        $file=Request::file('cate_img');
        $data=Request::only(['cate_name','iconfont','description','pid','keywords','show_cate']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('cate_img'));
            $this->cate_img=$path;
        }
        return $this->save($data) ? true : false;
    }

    public function getCateImgAttr($value)
    {
        if($value){
            return config('app.app_host').'/uploads/'.$value;
        }
    }

    public function child()
    {
        return $this->hasMany('Category','pid','id');
    }

    public function categoryWords()
    {
        return $this->hasMany('CategoryWords','category_id','id');
    }

    public function categoryBrands()
    {
        return $this->hasMany('CategoryBrands','category_id','id');
    }

    public function categoryAd()
    {
        return $this->hasMany('CategoryAd','category_id','id');
    }

}
