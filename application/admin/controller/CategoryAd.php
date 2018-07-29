<?php

namespace app\admin\controller;

use app\admin\validate\CategoryAdCheck;
use app\admin\validate\IDCheck;
use think\Controller;

class CategoryAd extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 左图关联列表
     */
    public function index()
    {
        $categoryAds=\app\admin\model\CategoryAd::with('category')->order('id','desc')->paginate(10);
        $this->assign(compact('categoryAds'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增左图关联界面
     */
    public function create()
    {
        $categories=\app\admin\model\Category::where('pid',0)->select();
        $this->assign(compact('categories'));
        return view();
    }

    /**
     * 新增左图关联操作
     */
    public function store()
    {
        //数据验证
        (new CategoryAdCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\CategoryAd::storeCategoryAd();
        if(!$result){
            $this->error('新增左图关联失败！');
        }
        $this->success('新增左图关联成功！','/admin/category_ad');
    }

    /**
     * 编辑左图关联界面
     */
    public function edit(\app\admin\model\CategoryAd $categoryAd)
    {
        (new IDCheck())->goCheck();
        $categories=\app\admin\model\Category::where('pid',0)->select();
        $this->assign(compact('categoryAd','categories'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\CategoryAd $categoryAd)
    {
        (new IDCheck())->goCheck();

        (new CategoryAdCheck())->goCheck();

        $result=$categoryAd->updateCategoryAd();
        if(!$result){
            $this->error('更新左图关联失败！');
        }
        $this->success('更新左图关联成功！','/admin/category_ad');
    }


    //删除左图关联
    public function destroy(\app\admin\model\CategoryAd $categoryAd)
    {
        (new IDCheck())->goCheck();
        $result=$categoryAd->delete();
        if(!$result){
            $this->error('删除左图关联失败');
        }
        $this->success('删除左图关联成功','/admin/category_ad');
    }
}
