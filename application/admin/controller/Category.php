<?php

namespace app\admin\controller;

use app\admin\model\Recpos;
use app\admin\validate\CategoryCheck;
use app\admin\validate\CategoryWordsCheck;
use app\admin\validate\IDCheck;
use app\admin\validate\SortCheck;
use app\lib\Utils;
use think\Controller;
use think\facade\Request;

class Category extends Controller
{
    /**
     * 商品分类列表
     */
    public function index()
    {
        $categories=\app\admin\model\Category::order('sort','desc')->select();
        //无限极分类
        $categories=Utils::treeSort($categories);
        $this->assign(compact('categories'));
        return view();
    }

    /**
     * 添加界面
     */
    public function create()
    {
        //获取所有分类推荐位
        $recpoes=\app\admin\model\Recpos::where('rec_type',2)->select();

        $categories=\app\admin\model\Category::order('sort','desc')->select();
        //无限极分类
        $categories=Utils::treeSort($categories);
        $this->assign(compact('categories','recpoes'));
        return view();
    }

    /**
     * @throws \app\exception\ParamsException
     * 商品分类添加
     */
    public function store(\app\admin\model\Category $category)
    {
        (new CategoryCheck())->goCheck();
        $result=$category->updateCategory();
        if(!$result){
            $this->error('新增商品分类失败！');
        }
        $this->success('新增商品分类成功！','/admin/category');
    }

    /**
     * 商品ajax排序
     */
    public function sort(\app\admin\model\Category $category)
    {
        (new SortCheck())->goCheck();
        $result=$category->save(Request::only(['sort']));
        if($result){
            return json([
                'status'=>1,
                'msg'=>'排序成功'
            ]);
        }else{
            return json([
                'status'=>0,
                'msg'=>'排序失败'
            ]);
        }
    }

    /**
     * @param $id
     * @return \think\response\View
     * @throws \app\exception\ParamsException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 编辑商品分类界面
     */
    public function edit(\app\admin\model\Category $category)
    {
        (new IDCheck())->goCheck();

        //获取所有分类推荐位
        $recpoes=\app\admin\model\Recpos::where('rec_type',2)->select();

        //获取当前分类所有的推荐位,拆分为一维数组
        $__categoryRecpoes=db('rec_item')->where(['value_id'=>$category->id,'value_type'=>2])->select();
        $categoryRecpoes=[];
        foreach ($__categoryRecpoes as $k=>$v){
            $categoryRecpoes[]=$v['recpos_id'];
        }


        $categories=\app\admin\model\Category::order('sort','desc')->select();
        //无限极分类
        $categories=Utils::treeSort($categories);
        $this->assign(compact('categories','category','recpoes','categoryRecpoes'));
        return view();
    }

    /**
     * @throws \app\exception\ParamsException
     * 商品分类更新
     */
    public function update(\app\admin\model\Category $Category)
    {
        (new IDCheck())->goCheck();
        (new CategoryCheck())->goCheck();
        $result=$Category->updateCategory();
        if(!$result){
            $this->error('更新商品分类失败！');
        }
        $this->success('更新商品分类成功！','/admin/category');
    }

    /**
     * @param $id
     * @throws \app\exception\ParamsException
     * 删除商品分类
     */
    public function destroy(\app\admin\model\Category $category)
    {
        (new IDCheck())->goCheck();
        $result=$category->delete();
        if(!$result){
            $this->error('删除商品分类失败');
        }
        $this->success('删除商品分类成功','/admin/category');
    }
}
