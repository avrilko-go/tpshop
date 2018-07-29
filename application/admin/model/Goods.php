<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class Goods extends Model
{

    protected static function init()
    {
        self::observe(\app\admin\event\Goods::class);
    }

    /**
     * @return bool
     * @throws \think\Exception
     * 添加商品
     */
    public static function createGoods()
    {
        $file=Request::file('og_thumb');
        $data=Request::only(['goods_name','on_sale','type_id','category_id','brand_id','markte_price','shop_price','goods_weight','weight_unit','goods_des']);
        if($file){
            $arr=self::makeThumb($file);
            $data=array_merge($data,$arr);
        }
        return self::create($data)->id ? true : false;

    }

    /**
     * 修改商品信息
     */
    public function updateGoods()
    {
        $file=Request::file('og_thumb');
        $data=Request::only(['goods_name','on_sale','type_id','category_id','brand_id','markte_price','shop_price','goods_weight','weight_unit','goods_des']);
        if($file){
            $arr=Goods::makeThumb($file);
            @unlink('./uploads/'.Request::post('og_thumb'));
            @unlink('./uploads/'.Request::post('big_thumb'));
            @unlink('./uploads/'.Request::post('mid_thumb'));
            @unlink('./uploads/'.Request::post('sm_thumb'));
            $data=array_merge($data,$arr);
        }
        return $this->save($data);
    }




    /**
     * @param $file
     * @return array
     * @throws \think\Exception
     * 根据业务生成三张缩略图
     */
    public static function makeThumb($file)
    {
        $path=ImageHandler::upload($file);
        $realpath='./uploads/'.$path;
        $filename=substr($path,9);

        $sm_path=date('Ymd').'/sm_'.$filename;
        $md_path=date('Ymd').'/md_'.$filename;
        $bg_path=date('Ymd').'/bg_'.$filename;

        $arr=[
            'og_thumb'=>$path,
            'sm_thumb'=>$sm_path,
            'mid_thumb'=>$md_path,
            'big_thumb'=>$bg_path
        ];

        ImageHandler::makeThumb($realpath,'./uploads/'.$sm_path,config('image.thumb_small.height'),config('image.thumb_small.width'));
        ImageHandler::makeThumb($realpath,'./uploads/'.$md_path,config('image.thumb_middle.height'),config('image.thumb_middle.width'));
        ImageHandler::makeThumb($realpath,'./uploads/'.$bg_path,config('image.thumb_big.height'),config('image.thumb_big.width'));

        return $arr;
    }

    public function category()
    {
        return $this->belongsTo('Category','category_id','id');
    }

    public function brand()
    {
        return $this->belongsTo('Brand','brand_id','id');
    }

    public function type()
    {
        return $this->belongsTo('Type','type_id','id');
    }

    public function product()
    {
        return $this->hasMany('Product','goods_id','id');
    }

    public function memberPrice()
    {
        return $this->hasMany('MemberPrice','goods_id','id');
    }

    public function goodsPhoto()
    {
        return $this->hasMany('GoodsPhoto','goods_id','id');
    }

    public function getSmThumbAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    public function getBigThumbAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    public function getMidThumbAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    public function getOgThumbAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }


}
