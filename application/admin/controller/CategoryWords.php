<?php

namespace app\admin\controller;

use app\admin\validate\CategoryWordsCheck;
use app\admin\validate\IDCheck;
use think\Controller;
use think\facade\Request;

class CategoryWords extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 推荐词关联列表
     */
    public function index()
    {
        $categoryWords=\app\admin\model\CategoryWords::with('category')->order('id','desc')->paginate(10);
        $this->assign(compact('categoryWords'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增推荐词关联界面
     */
    public function create()
    {
        $categories=\app\admin\model\Category::where('pid',0)->select();
        $this->assign(compact('categories'));
        return view();
    }

    /**
     * 新增推荐词关联操作
     */
    public function store()
    {
        //数据验证
        (new CategoryWordsCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\CategoryWords::create(Request::only(['category_id','word','link_url']));
        if(!$result){
            $this->error('新增推荐词关联失败！');
        }
        $this->success('新增推荐词关联成功！','/admin/category_words');
    }

    /**
     * 编辑推荐词关联界面
     */
    public function edit(\app\admin\model\CategoryWords $categoryWords)
    {
        (new IDCheck())->goCheck();
        $categories=\app\admin\model\Category::where('pid',0)->select();
        $this->assign(compact('categoryWords','categories'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\CategoryWords $categoryWords)
    {
        (new IDCheck())->goCheck();

        (new CategoryWordsCheck())->goCheck();

        $result=$categoryWords->save(Request::only(['category_id','word','link_url']));
        if(!$result){
            $this->error('更新推荐词关联失败！');
        }
        $this->success('更新推荐词关联成功！','/admin/category_words');
    }


    //删除推荐词关联
    public function destroy(\app\admin\model\CategoryWords $categoryWords)
    {
        (new IDCheck())->goCheck();
        $result=$categoryWords->delete();
        if(!$result){
            $this->error('删除推荐词关联失败');
        }
        $this->success('删除推荐词关联成功','/admin/category_words');
    }
}
