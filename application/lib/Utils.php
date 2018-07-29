<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 19:25
 */

namespace app\lib;


class Utils
{
    //判断用户输入的url中是否带有http或https 没有加上
    public static function urlChange($url)
    {
        if(stripos($url,'http')===false){
            return 'http://'.$url;
        }
        return $url;
    }

    /**
     * @param $data
     * @return array
     * 无限极分类排序
     */
    public static function treeSort($data)
    {
        return self::__treeSort($data);
    }

    private static function __treeSort($data,$pid=0,$level=0)
    {
        static $arr=[];
        foreach ($data as $key=>$value){
            if($value['pid']==$pid){
                $value['level']=$level;
                array_push($arr,$value);
                self::__treeSort($data,$value['id'],$level+1);
            }
        }
        return $arr;
    }

    /**
     * @param $id
     * @param $all
     * @return array
     * 获取所有子元素id
     */
    public static function getSon($id,$all)
    {
        return self::__getSon($id,$all,true);
    }

    private static function __getSon($id,$all,$flag)
    {
        static $arr=[];
        if($flag){
            $arr=[];
        }
        foreach ($all as $k=>$v){
            if($v['pid']==$id){
                array_push($arr,$v['id']);
                self::__getSon($v['id'],$all,false);
            }
        }
        return $arr;
    }


    /**
     * 获取所有父元素id
     */
    public static function getParent($id,$obj)
    {
        $all=$obj->select();
        $pid=$obj->find($id)->pid;

        $arr=self::__getParent($pid,$all);
        return $arr;

    }

    private static function __getParent($pid,$all)
    {
        static $arr=[];
        foreach ($all as $k=>$v){
            if($v['id']==$pid){
                array_push($arr,$v['id']);
                if($v['pid']==0){
                    continue;
                }
                self::__getParent($v['pid'],$all);
            }
        }
        return $arr;
    }

    /**
     * @param string $dir
     * @return array
     * 递归计算ueditor上传的图片地址
     */
    public static function scanDir($dir='')
    {
        static $images=[];
        $dirs=scandir($dir);
        foreach ($dirs as $v){
            if($v!=='.' && $v!=='..'){
                if(is_dir($dir.'/'.$v)){
                    self::scanDir($dir.'/'.$v);
                }else{
                    array_push($images, substr($dir.'/'.$v,1));
                }
            }
        }
        return $images;
    }

    //加密字符串
    public static function encrypt($value)
    {
        $key=md5(config('app.app_host'));
        return base64_encode($value^$key);
    }

    //解密字符串
    public static function decrypt($value)
    {
        $key=md5(config('app.app_host'));
        return base64_decode($value)^$key;

    }

}