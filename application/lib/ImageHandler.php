<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/25
 * Time: 18:20
 */

namespace app\lib;


use think\Exception;
use think\facade\Request;

class ImageHandler
{
    /**
     * @param $file
     * @return mixed
     * @throws Exception
     * 单图上传
     */
    public static function upload($file)
    {
        $info = $file->move(config('image.admin_upload_path'));
        if($info){
            return $info->getSaveName();
        }else{
            throw new Exception('上传图片失败');
        }
    }

    /**
     * @return array
     * @throws Exceptiond
     * 多图上传
     */
    public static function uploads()
    {
        $files=Request::file();
        $arr=[];
        foreach ($files as $k=>$file){
            $path=self::upload($file);
            $arr[$k]=$path;
        }
        return $arr;
    }

    /**
     * @param $file
     * @param $savepath
     * @param $height
     * @param $width
     * 按照高度宽度生成缩略图
     */
    public static function makeThumb($file,$savepath,$height=200,$width=200)
    {
        $image = \think\Image::open($file);
        $image->thumb($width,$height)->save($savepath);
    }


}