<?php

namespace app\admin\model;

use app\lib\ImageHandler;
use think\facade\Request;
use think\Model;

class Conf extends Model
{
    protected static function init()
    {
        self::observe(\app\admin\event\Conf::class);
    }

    /**
     * @return bool
     * 新增配置
     */
    public static function storeConf()
    {
        $data=Request::only(['ename','cname','form_type','conf_type','values','value']);
        $conf=self::create($data);
        return $conf->id ? true : false;
    }

    /**
     * @return bool
     * 更新配置
     */
    public function updateConf()
    {
        $data=Request::only(['ename','cname','form_type','conf_type','values','value']);
        return $this->save($data) ? true :false;
    }


    /**
     * @param $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 将checkbox置空的value值设置为空
     */
    public static function updateEmptyCheckbox($data)
    {
        //查询conf中所有的checkbox
        $arr=self::where('form_type','checkbox')->select();
        $checkbox=[];
        foreach ($arr as $k=>$v){
            array_push($checkbox,$v['ename']);
        }

        //统计前台传递过来的checkbox
        $postCheckbox=[];
        foreach ($data as $k =>$v){
            if(is_array($v)){
                array_push($postCheckbox,$k);
            }
        }

        //取差集得到前台CheckBox置空的ename,并且将其值置空
        $emptyCheckbox=array_diff($checkbox,$postCheckbox);
        if($emptyCheckbox){
            foreach ($emptyCheckbox as $k=>$v){
                self::where('ename',$v)->update(['value'=>'']);
            }
        }
    }

    /**
     * 配置的多图上传操作
     */
    public static function uploadImages()
    {
        $arr=ImageHandler::uploads();
        if($arr){
            foreach ($arr as $k=>$v){
                $conf=self::where('ename',$k)->find();
                if($conf->value){
                    @unlink('./uploads/'.$conf->value);
                }
                $conf->value=$v;
                $conf->save();
            }
        }
    }
}
