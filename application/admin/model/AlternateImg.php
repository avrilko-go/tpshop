<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class AlternateImg extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\AlternateImg::class);
    }

    public function getImgSrcAttr($value)
    {
        if($value){
            return config('app.app_host').'/uploads/'.$value;
        }
    }


    public static function storeAlternateImg()
    {
        $file=Request::file('img_src');
        $data=Request::only(['title','link_url','status']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['img_src']=$path;
        }
        $alternateImg=self::create($data);
        return $alternateImg->id ? true : false;
    }

    public function updateAlternateImg()
    {
        $file=Request::file('img_src');
        $data=Request::only(['title','link_url','status']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('img_src'));
            $this->img_src=$path;
        }
        return $this->save($data) ? true : false;
    }


}
