<?php

namespace app\admin\controller;

use app\admin\validate\CateCheck;
use app\admin\validate\SortCheck;
use app\admin\validate\IDCheck;
use app\lib\Utils;
use think\Controller;
use think\facade\Request;

class Cate extends Controller
{
    /**
     * 文章分类列表
     */
    public function index()
    {
        $caties=\app\admin\model\Cate::order('sort','desc')->select();
        //无限极分类
        $caties=Utils::treeSort($caties);
        $this->assign(compact('caties'));
        return view();
    }

    /**
     * 添加界面
     */
    public function create()
    {
        $caties=\app\admin\model\Cate::order('sort','desc')->select();
        //无限极分类
        $caties=Utils::treeSort($caties);
        $this->assign(compact('caties'));
        return view();
    }

    /**
     * @throws \app\exception\ParamsException
     * 文章分类添加
     */
    public function store()
    {
        (new CateCheck())->goCheck();
        $result=\app\admin\model\Cate::storeCate();
        if(!$result){
            $this->error('新增文章分类失败！');
        }
        $this->success('新增文章分类成功！','/admin/cate');
    }

    /**
     * 文章ajax排序
     */
    public function sort(\app\admin\model\Cate $cate)
    {
        (new SortCheck())->goCheck();
        $result=$cate->save(Request::only(['sort']));
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
     * 编辑文章分类界面
     */
    public function edit(\app\admin\model\Cate $cates)
    {
        (new IDCheck())->goCheck();
        $caties=\app\admin\model\Cate::order('sort','desc')->select();
        //无限极分类
        $caties=Utils::treeSort($caties);
        $this->assign(compact('cates'));
        $this->assign(compact('caties'));
        return view();
    }

    /**
     * @throws \app\exception\ParamsException
     * 文章分类更新
     */
    public function update(\app\admin\model\Cate $cate)
    {
        (new IDCheck())->goCheck();
        (new CateCheck())->goCheck();
        $result=$cate->updateCate();
        if(!$result){
            $this->error('更新文章分类失败！');
        }
        $this->success('更新文章分类成功！','/admin/cate');
    }

    /**
     * @param $id
     * @throws \app\exception\ParamsException
     * 删除文章分类
     */
    public function destroy(\app\admin\model\Cate $cate)
    {
        (new IDCheck())->goCheck();
        $result=$cate->delete();
        if(!$result){
            $this->error('删除文章分类失败');
        }
        $this->success('删除文章分类成功','/admin/cate');
    }
}
