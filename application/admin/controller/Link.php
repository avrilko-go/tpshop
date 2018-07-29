<?php

namespace app\admin\controller;

use app\admin\validate\SortCheck;
use app\admin\validate\IDCheck;
use app\admin\validate\LinkCheck;
use think\Controller;
use think\facade\Request;

class Link extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 友情链接列表
     */
    public function index()
    {
        $links=\app\admin\model\Link::order('id','desc')->paginate(10);
        $this->assign(compact('links'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增友情链接界面
     */
    public function create()
    {
        return view();
    }

    /**
     * 新增友情链接操作
     */
    public function store()
    {
        //数据验证
        (new LinkCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\Link::storeLink();
        if(!$result){
            $this->error('新增友情链接失败！');
        }
        $this->success('新增友情链接成功！','/admin/link');
    }

    /**
     * 编辑友情链接界面
     */
    public function edit(\app\admin\model\Link $link)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('link'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\Link $link)
    {
        (new LinkCheck())->goCheck();
        $result= $link->updateLink();
        if(!$result){
            $this->error('更新友情链接失败！');
        }
        $this->success('更新友情链接成功！','/admin/link');
    }


    //删除友情链接
    public function destroy(\app\admin\model\Link $link)
    {
        (new IDCheck())->goCheck();
        $result=$link->delete();
        if(!$result){
            $this->error('删除友情链接失败');
        }
        $this->success('删除友情链接成功','/admin/link');
    }



}
