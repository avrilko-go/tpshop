<?php

namespace app\admin\controller;

use app\admin\validate\IDCheck;
use app\admin\validate\RecposCheck;
use think\Controller;
use think\facade\Request;

class Recpos extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 推荐位列表
     */
    public function index()
    {
        $recpoes=\app\admin\model\Recpos::order('id','desc')->paginate(10);
        $this->assign(compact('recpoes'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增推荐位界面
     */
    public function create()
    {
        return view();
    }

    /**
     * 新增推荐位操作
     */
    public function store()
    {
        //数据验证
        (new RecposCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\Recpos::create(Request::only(['rec_name','rec_type']));
        if(!$result->id){
            $this->error('新增推荐位失败！');
        }
        $this->success('新增推荐位成功！','/admin/recpos');
    }

    /**
     * 编辑推荐位界面
     */
    public function edit(\app\admin\model\Recpos $recpos)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('recpos'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\Recpos $recpos)
    {
        (new RecposCheck())->goCheck();
        $result= $recpos->save(Request::only(['rec_name','rec_type']));
        if(!$result){
            $this->error('更新推荐位失败！');
        }
        $this->success('更新推荐位成功！','/admin/recpos');
    }


    //删除推荐位
    public function destroy(\app\admin\model\Recpos $recpos)
    {
        (new IDCheck())->goCheck();
        $result=$recpos->delete();
        if(!$result){
            $this->error('删除推荐位失败');
        }
        $this->success('删除推荐位成功','/admin/recpos');
    }
}
