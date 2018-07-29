<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use app\lib\Utils;
use think\facade\Request;
use think\Model;

class Article extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Article::class);
    }

    public function cate()
    {
        return $this->belongsTo('Cate','cate_id','id');
    }

    public function getAddtimeAttr($value)
    {
        return date('Y-m-d H:i:s',$value);
    }

    public function getThumbAttr($value)
    {
        if($value){
            return config('app_host').'/uploads/'.$value;
        }

    }

    //获取面包屑栏目
    public function getPosition()
    {
        $cate_id=$this->cate_id;
        $cateobj=new \app\admin\model\Cate();
        $cate_ids=Utils::getParent($cate_id,$cateobj);
        $cate_ids=array_reverse($cate_ids);
        $arr=[];
        foreach ($cate_ids as $k=>$v){
            $data=Cate::get($v);
            array_push($arr,$data);
        }
        return $arr;
    }

    /**
     * @return bool
     * @throws \think\Exception
     * 新增文章操作
     */
    public static function storeArticle()
    {
        $file=Request::file('thumb');
        $data=Request::only(['title','keywords','description','author','email','link_url','content','cate_id','show_top']);
        if($file){
            $path=ImageHandler::upload($file);
            $data['thumb']=$path;
        }
        $article=self::create($data);
        return $article->id ? true : false;
    }


    /**
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * 更新文章操作
     */
    public function updateArticle()
    {
        $file=Request::file('thumb');
        $data=Request::only(['title','keywords','description','author','email','link_url','content','cate_id','show_top']);
        if($file){
            $path=ImageHandler::upload($file);
            @unlink('./uploads/'.$this->getData('thumb'));
            $this->thumb=$path;
        }
        return $this->save($data) ? true : false;
    }
}
