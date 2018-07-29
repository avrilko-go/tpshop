<?php

namespace app\admin\controller;

use app\admin\validate\IDCheck;
use app\admin\validate\SortCheck;
use think\Controller;
use think\facade\Request;

class AlternateImg extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 轮播图列表
     */
    public function index()
    {
        //关联预查询
        $alternateImgs=\app\admin\model\AlternateImg::order('sort','desc')->paginate(15);
        $this->assign(compact('alternateImgs'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增轮播图界面
     */
    public function create()
    {
        return view();
    }

    /**
     * 新增轮播图操作
     */
    public function store()
    {
        //数据验证
        (new \app\admin\validate\AlternateImg())->goCheck();
        //新增操作
        $result=\app\admin\model\AlternateImg::storeAlternateImg();
        if(!$result){
            $this->error('新增轮播图失败！');
        }
        $this->success('新增轮播图成功！','/admin/alternate_img');
    }

    /**
     * 编辑轮播图界面
     */
    public function edit(\app\admin\model\AlternateImg $alternateImg)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('alternateImg'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\AlternateImg $alternateImg)
    {
        (new IDCheck())->goCheck();
        (new \app\admin\validate\AlternateImg())->goCheck();
        $result= $alternateImg->updateAlternateImg();
        if(!$result){
            $this->error('更新轮播图失败！');
        }
        $this->success('更新轮播图成功！','/admin/alternate_img');
    }


    //删除轮播图
    public function destroy(\app\admin\model\AlternateImg $alternateImg)
    {
        (new IDCheck())->goCheck();
        $result=$alternateImg->delete();
        if(!$result){
            $this->error('删除轮播图失败');
        }
        $this->success('删除轮播图成功','/admin/alternate_img');
    }

    /**
     * 轮播图ajax排序
     */
    public function sort(\app\admin\model\AlternateImg $alternateImg)
    {
        (new SortCheck())->goCheck();
        $result=$alternateImg->save(Request::only(['sort']));
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
}
