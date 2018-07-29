<?php

namespace app\admin\model;

use think\Model;

class GoodsPhoto extends Model
{

    protected static function init()
    {
        self::observe(\app\admin\event\GoodsPhoto::class);
    }


    public function getSmPhotoAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    public function getBigPhotoAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    public function getMidPhotoAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }

    public function getOgPhotoAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }
    }
}
