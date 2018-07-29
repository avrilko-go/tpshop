<?php
/**
 * Created by PhpStorm.
 * User: hebing
 * Date: 2018/6/27
 * Time: 21:16
 */

namespace app\admin\event;


use app\lib\Utils;
use think\facade\Request;

class Category
{
    public function beforeDelete($category)
    {
        if($category->cate_img){
            @unlink('./uploads/'.$category->cate_img);
        }

        //如果为顶级栏目则删除关联左图，推荐词，品牌
        if($category->pid==0){
            db('category_ad')->where('category_id',$category->id)->delete();
            db('category_brands')->where('category_id',$category->id)->delete();
            db('category_words')->where('category_id',$category->id)->delete();
        }


        $all=\app\admin\model\Category::all();
        //获取所有子栏目
        $son_ids=Utils::getSon($category->id,$all);
        //删除所有子栏目
        db('category')->delete($son_ids);
        array_push($son_ids,$category->id);
        foreach ($son_ids as $k=>$v){
            db('rec_item')->where(['value_type'=>2,'value_id'=>$v])->delete();
        }


        //删除分类推荐位
        $this->deleteCategoryRecpos($category);

    }


    public function afterInsert($category)
    {
        //创建分类推荐位
        $this->createCategoryRecpos($category);
    }


    public function beforeUpdate($category)
    {
        //删除分类推荐位
        $this->deleteCategoryRecpos($category);
        $this->createCategoryRecpos($category);
    }

    //创建分类推荐位
    private function createCategoryRecpos($category)
    {
        $recpos=Request::post('recpos');
        if($recpos){
            foreach ($recpos as $k => $v){
                db('rec_item')->insert(['recpos_id'=>$v,'value_id'=>$category->id,'value_type'=>2]);
            }
        }
    }

    //删除分类推荐位
    private function deleteCategoryRecpos($category)
    {

        db('rec_item')->where(['value_id'=>$category->id,'value_type'=>2])->delete();
    }
}