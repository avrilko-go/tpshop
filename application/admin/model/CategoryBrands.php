<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class CategoryBrands extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\CategoryBrands::class);
    }

    public function getProImgAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    //增加品牌关联
    public static function storeCategoryBrands()
    {
        $file=Request::file('pro_img');
        $data=Request::only(['brands_id','pro_url','category_id']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['pro_img']=$path;
        }
        $categoryBrand=self::create($data);
        return $categoryBrand->id ? true : false;
    }

    //更新品牌关联
    public function updateCategoryBrands()
    {
        $file=Request::file('pro_img');
        $data=Request::only(['brands_id','pro_url','category_id']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('pro_img'));
            $this->pro_img=$path;
        }
        return $this->save($data) ? true : false;
    }




}
