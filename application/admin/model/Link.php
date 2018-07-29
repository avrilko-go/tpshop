<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class Link extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Link::class);
    }

    public function getLogoAttr($value)
    {
        if($value){
            return config('app.app_host').'/uploads/'.$value;
        }

    }

    /**
     * @return bool
     * @throws \think\Exception
     * 静态调用增加友情链接
     */
    public static function storeLink()
    {
        $file=Request::file('logo');
        $data=Request::only(['title','link_url','description','type','status']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['logo']=$path;
        }
        $link=self::create($data);
        return $link->id ? true : false;
    }

    /**
     * @return bool
     * @throws \think\Exception
     * 更新友情链接
     */
    public function updateLink()
    {
        $file=Request::file('logo');
        $data=Request::only(['title','link_url','description','type','status']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('logo'));
            $this->logo=$path;
        }
        return $this->save($data) ? true : false;
    }
}
