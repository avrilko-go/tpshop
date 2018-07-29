<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/26
 * Time: 14:33
 */

namespace app\admin\event;


use app\lib\Utils;

class Cate
{
    /**
     * @param $cate
     * 当上级分类是网店帮助分类 自动设置类型我网店帮助
     */
    public function beforeInsert($cate)
    {
        if($cate->pid==2){
            $cate->cate_type=3;
            $cate->allow_son=0;
        }
    }

    /**
     * @param $cate
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * 删除所有子分类
     */
    public function beforeDelete($cate)
    {
        $all=\app\admin\model\Cate::all();
        //获取所有子栏目
        $son_ids=Utils::getSon($cate->id,$all);
        //删除所有子栏目
        db('cate')->delete($son_ids);

        //删除子栏目和自身对应的文章 自动触发模型事件
        array_push($son_ids,$cate->id);
        foreach ($son_ids as $k=>$v){
            \app\admin\model\Article::destroy(function ($query) use ($v) {
                $query->where('cate_id',$v);
            });
        }


    }

}