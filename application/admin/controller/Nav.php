<?php

namespace app\admin\controller;

use app\admin\validate\IDCheck;
use app\admin\validate\NavCheck;
use app\admin\validate\SortCheck;
use think\Controller;
use think\facade\Request;

class Nav extends Controller
{
    /**
     * 导航列表
     */
    public function index()
    {
        $navs=\app\admin\model\Nav::order('sort','desc')->paginate(10);
        $this->assign(compact('navs'));
        return view();
    }

    /**
     * 添加界面
     */
    public function create()
    {
        return view();
    }

    /**
     * @throws \app\exception\ParamsException
     * 导航添加
     */
    public function store()
    {
        (new NavCheck())->goCheck();
        $result=\app\admin\model\Nav::create(Request::only(['nav_name','nav_url','open','pos']));
        if(!$result->id){
            $this->error('新增导航失败！');
        }
        $this->success('新增导航成功！','/admin/nav');
    }

    /**
     * 文章ajax排序
     */
    public function sort(\app\admin\model\Nav $nav)
    {
        (new SortCheck())->goCheck();
        $result=$nav->save(Request::only(['sort']));
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
     * 编辑导航界面
     */
    public function edit(\app\admin\model\Nav $nav)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('nav'));
        return view();
    }

    /**
     * @throws \app\exception\ParamsException
     * 导航更新
     */
    public function update(\app\admin\model\Nav $nav)
    {
        (new IDCheck())->goCheck();
        (new NavCheck())->goCheck();
        $result=$nav->save(Request::only(['nav_name','nav_url','open','pos']));
        if(!$result){
            $this->error('更新导航失败！');
        }
        $this->success('更新导航成功！','/admin/nav');
    }

    /**
     * @param $id
     * @throws \app\exception\ParamsException
     * 删除导航
     */
    public function destroy(\app\admin\model\Nav $nav)
    {
        (new IDCheck())->goCheck();
        $result=$nav->delete();
        if(!$result){
            $this->error('删除导航失败');
        }
        $this->success('删除导航成功','/admin/nav');
    }
}
