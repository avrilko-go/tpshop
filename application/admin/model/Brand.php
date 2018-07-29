<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class Brand extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Brand::class);
    }

    /**
     * @return bool
     * @throws \think\Exception
     * 商品品牌写入数据库
     */
    public static function storeBrand()
    {
        $file=Request::file('brand_img');
        $data=Request::only(['brand_name','brand_url','brand_description','status']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['brand_img']=$path;
        }
        $brand=self::create($data);
        return $brand->id ? true : false;
    }

    /**
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 更新操作
     */
    public function updateBrand()
    {
        $file=Request::file('brand_img');
        $data=Request::only(['brand_name','brand_url','brand_description','status']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('brand_img'));
            $this->brand_img=$path;
        }
        return $this->save($data) ? true : false;
    }


    public function getBrandImgAttr($value)
    {
        if($value){
            return config('app.app_host').'/uploads/'.$value;
        }

    }

}
