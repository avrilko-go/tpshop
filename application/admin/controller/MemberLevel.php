<?php

namespace app\admin\controller;

use app\admin\validate\IDCheck;
use app\admin\validate\MemberLevelCheck;
use think\Controller;

class MemberLevel extends Controller
{
    /**
     * @return \think\response\View
     * @throws \think\exception\DbException
     * 会员等级列表
     */
    public function index()
    {
        $memberLevels=\app\admin\model\MemberLevel::order('id','desc')->paginate(15);
        $this->assign(compact('memberLevels'));
        return view();
    }

    /**
     * @return \think\response\View
     * 新增会员等级界面
     */
    public function create()
    {
        $memberLevels=\app\admin\model\MemberLevel::all();

        $this->assign(compact('memberLevels'));

        return view();
    }

    /**
     * 新增会员等级操作
     */
    public function store()
    {
        //数据验证
        (new MemberLevelCheck())->goCheck();
        //新增操作
        $result=\app\admin\model\MemberLevel::create($this->request->only(['level_name','bom_point','top_point','rate']));
        if(!$result){
            $this->error('新增会员等级失败！');
        }
        $this->success('新增会员等级成功！','/admin/memberLevel');
    }

    /**
     * 编辑会员等级界面
     */
    public function edit(\app\admin\model\MemberLevel $memberLevel)
    {
        (new IDCheck())->goCheck();
        $this->assign(compact('memberLevel'));
        return view();
    }

    /**
     * 编辑提交
     */
    public function update(\app\admin\model\MemberLevel $memberLevel)
    {
        (new IDCheck())->goCheck();
        (new MemberLevelCheck())->goCheck();
        $result= $memberLevel->save($this->request->only(['level_name','bom_point','top_point','rate']));
        if(!$result){
            $this->error('更新会员等级失败！');
        }
        $this->success('更新会员等级成功！','/admin/memberLevel');
    }


    //删除会员等级
    public function destroy(\app\admin\model\MemberLevel $memberLevel)
    {
        (new IDCheck())->goCheck();
        $result=$memberLevel->delete();
        if(!$result){
            $this->error('删除会员等级失败');
        }
        $this->success('删除会员等级成功','/admin/memberLevel');
    }
}
